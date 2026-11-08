"""Targeted BAJI FTP repair. No deletion beyond rollback of newly created files."""
import ftplib
import hashlib
import json
import os
import pathlib
import sys
import time
import urllib.error
import urllib.request

ROOT = pathlib.Path(__file__).resolve().parents[2]
BACKUP = ROOT / ".baji-deploy-backup"
BACKUP.mkdir(exist_ok=True)
FILES = (
    "functions.php",
    "assets/js/main.js",
    "assets/css/custom.css",
    "assets/vendor/swiper/swiper-bundle.min.js",
    "assets/vendor/swiper/swiper-bundle.min.css",
    "assets/images/banner-instagram2.webp",
    "assets/images/banner-bale2.webp",
    "assets/webfonts/fa-regular-400.woff2",
)
VERIFY = tuple(path for path in FILES if path.startswith("assets/"))

for name in FILES:
    if not (ROOT / name).is_file():
        raise RuntimeError(f"Missing candidate file: {name}")

if not all(os.environ.get(key) for key in ("FTP_SERVER", "FTP_USERNAME", "FTP_PASSWORD")):
    raise RuntimeError("FTP credentials are unavailable; deployment aborted")

ftp = ftplib.FTP()
ftp.connect(os.environ["FTP_SERVER"], 21, timeout=35)
ftp.login(os.environ["FTP_USERNAME"], os.environ["FTP_PASSWORD"])
ftp.set_pasv(True)
ftp.voidcmd("TYPE I")

# Verify the FTP root actually points at the installed theme.
try:
    ftp.size("functions.php")
    ftp.size("front-page.php")
except ftplib.all_errors as exc:
    ftp.quit()
    raise RuntimeError("FTP root does not look like BAJI theme; refusing upload") from exc

manifest = []
for name in FILES:
    dst = BACKUP / name
    dst.parent.mkdir(parents=True, exist_ok=True)
    exists = False
    try:
        with dst.open("wb") as fh:
            ftp.retrbinary("RETR " + name, fh.write, blocksize=32768)
        exists = True
    except ftplib.error_perm as exc:
        if not str(exc).startswith("550"):
            raise
        dst.unlink(missing_ok=True)
    manifest.append({
        "path": name,
        "original_exists": exists,
        "old_sha256": hashlib.sha256(dst.read_bytes()).hexdigest() if exists else None,
        "new_sha256": hashlib.sha256((ROOT / name).read_bytes()).hexdigest(),
    })
(BACKUP / "manifest.json").write_text(json.dumps(manifest, indent=2), encoding="utf-8")
print("BACKUP_COMPLETE", len(manifest), "files (including missing-file markers)")

def ensure_parents(name):
    pieces = name.split("/")[:-1]
    prefix = ""
    for piece in pieces:
        prefix = f"{prefix}/{piece}" if prefix else piece
        try:
            ftp.mkd(prefix)
        except ftplib.error_perm as exc:
            if not str(exc).startswith("550"):
                raise

uploaded = []
try:
    for item in manifest:
        name = item["path"]
        ensure_parents(name)
        with (ROOT / name).open("rb") as fh:
            ftp.storbinary("STOR " + name, fh, blocksize=32768)
        uploaded.append(item)
        actual_size = ftp.size(name)
        if actual_size is not None and actual_size != (ROOT / name).stat().st_size:
            raise RuntimeError(f"FTP size differs for {name}")
        print("UPLOADED", name)

    ftp.quit()

    # Cache-busting requests verify that actual public assets can be served.
    for name in VERIFY:
        expected = (ROOT / name).stat().st_size
        uri = ("https://bajistyle.ir/wp-content/themes/bajistyle/" + name
               + "?baji_repair=" + hashlib.sha256((ROOT / name).read_bytes()).hexdigest()[:12])
        last = None
        for attempt in range(4):
            try:
                req = urllib.request.Request(uri, headers={"User-Agent": "BAJI-release-check/1.0"})
                with urllib.request.urlopen(req, timeout=20) as res:
                    data = res.read()
                    if res.status == 200 and len(data) == expected:
                        last = None
                        break
                    last = f"HTTP {res.status} bytes {len(data)} expected {expected}"
            except Exception as exc:
                last = str(exc)
            time.sleep(3)
        if last is not None:
            raise RuntimeError(f"Public verification failed for {name}: {last}")
        print("PUBLIC_OK", name)
    print("DEPLOYMENT_VERIFIED")
except Exception:
    # Reconnect on a fresh FTP session and restore original bytes or remove new files.
    print("DEPLOYMENT_FAILED_ROLLBACK_ATTEMPT", file=sys.stderr)
    try:
        try:
            ftp.quit()
        except Exception:
            pass
        restore = ftplib.FTP()
        restore.connect(os.environ["FTP_SERVER"], 21, timeout=35)
        restore.login(os.environ["FTP_USERNAME"], os.environ["FTP_PASSWORD"])
        for item in reversed(uploaded):
            name = item["path"]
            if item["original_exists"]:
                with (BACKUP / name).open("rb") as fh:
                    restore.storbinary("STOR " + name, fh, blocksize=32768)
                print("RESTORED", name)
            else:
                try:
                    restore.delete(name)
                    print("REMOVED_NEW_FILE", name)
                except ftplib.all_errors as exc:
                    print("ROLLBACK_REMOVE_FAILED", name, str(exc), file=sys.stderr)
        restore.quit()
    except Exception as rollback_error:
        print("ROLLBACK_INCOMPLETE", str(rollback_error), file=sys.stderr)
    raise
