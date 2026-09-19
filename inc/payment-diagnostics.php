<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action('rest_api_init', function () {
	register_rest_route('baji/v1','/payment-diagnostics',[
		'methods'=>'GET',
		'permission_callback'=>function(){ return current_user_can('manage_woocommerce') || current_user_can('manage_options'); },
		'args'=>['order_id'=>['type'=>'integer','required'=>true]],
		'callback'=>function($request){
			$order_id=(int)$request['order_id'];
			$order=wc_get_order($order_id);
			if(!$order) return new WP_Error('not_found','Order not found',['status'=>404]);
			$token=(string)$order->get_meta('_order_spp_token');
			if($token==='') $token=(string)$order->get_meta('_paymentToken');
			$tx=(string)$order->get_meta('_transactionId');
			$out=[
				'order_id'=>$order_id,
				'status'=>$order->get_status(),
				'date_paid'=>$order->get_date_paid() ? $order->get_date_paid()->date('c') : null,
				'transaction_id_present'=>$order->get_transaction_id() !== '',
				'gateway_class'=>null,
				'gateway_methods'=>[],
				'plugin_matches'=>[],
				'log_matches'=>[],
			];

			$gws=WC()->payment_gateways()->payment_gateways();
			foreach($gws as $id=>$gw){
				if($id==='WC_Gateway_SnappPay' || stripos(get_class($gw),'Snapp')!==false){
					$out['gateway_class']=get_class($gw);
					$ref=new ReflectionClass($gw);
					foreach($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $m){
						if(preg_match('/status|verify|settle|callback|payment|snapp|order|cancel/i',$m->getName())){
							$out['gateway_methods'][]=[
								'name'=>$m->getName(),
								'params'=>array_map(fn($p)=>$p->getName(),$m->getParameters()),
								'declaring_class'=>$m->getDeclaringClass()->getName(),
							];
						}
					}
				}
			}

			$plugin_dir=WP_PLUGIN_DIR.'/snapppay-woocommerce-gateway';
			$terms=['_wc_snapppay_check_status','verify','settle','status','callback','paymentToken','order_status','failed'];
			if(is_dir($plugin_dir)){
				$it=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($plugin_dir, FilesystemIterator::SKIP_DOTS));
				foreach($it as $file){
					if(!$file->isFile() || strtolower($file->getExtension())!=='php') continue;
					$path=$file->getPathname();
					$lines=@file($path, FILE_IGNORE_NEW_LINES);
					if(!is_array($lines)) continue;
					foreach($lines as $i=>$line){
						foreach($terms as $term){
							if(stripos($line,$term)!==false){
								$from=max(0,$i-2); $to=min(count($lines)-1,$i+2);
								$snippet=implode("\n",array_slice($lines,$from,$to-$from+1));
								$out['plugin_matches'][]=[
									'file'=>str_replace(WP_PLUGIN_DIR.'/','',$path),
									'line'=>$i+1,
									'term'=>$term,
									'snippet'=>$snippet,
								];
								break;
							}
						}
						if(count($out['plugin_matches'])>=180) break 2;
					}
				}
			}

			$needles=array_values(array_filter([(string)$order_id,$tx,$token,'SnappPay','snapppay']));
			$log_dir=defined('WC_LOG_DIR') ? WC_LOG_DIR : WP_CONTENT_DIR.'/uploads/wc-logs/';
			if(is_dir($log_dir)){
				$files=glob(trailingslashit($log_dir).'*.log') ?: [];
				usort($files,fn($a,$b)=>filemtime($b)<=>filemtime($a));
				foreach(array_slice($files,0,250) as $path){
					$size=@filesize($path);
					if($size===false || $size>20*1024*1024) continue;
					$lines=@file($path, FILE_IGNORE_NEW_LINES);
					if(!is_array($lines)) continue;
					foreach($lines as $i=>$line){
						$matched=false;
						foreach($needles as $needle){ if($needle!=='' && stripos($line,$needle)!==false){ $matched=true; break; } }
						if(!$matched) continue;
						$clean=$line;
						if($token!=='') $clean=str_replace($token,'[PAYMENT_TOKEN]',$clean);
						$out['log_matches'][]=[
							'file'=>basename($path),
							'line'=>$i+1,
							'text'=>$clean,
						];
						if(count($out['log_matches'])>=120) break 2;
					}
				}
			}

			return rest_ensure_response($out);
		}
	]);
});
