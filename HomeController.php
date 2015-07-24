<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Workerman\Worker;

class HomeController extends Controller {
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		require_once '/vendor/workerman/workerman/Autoloader.php';
		$http_worker = new Worker( "websocket://0.0.0.0:2345" );
		$http_worker->count = 4;
		$http_worker->onConnect = function ( $connection )
		{
			$connection->send ( 'id' . $connection->id );
		};

		$http_worker->onWorkerStart = function ( $worker )
		{
			// 定时，每10秒一次
			\Workerman\Lib\Timer::add ( 2 , function () use ( $worker )
			{
				// 遍历当前进程所有的客户端连接，发送当前服务器的时间
				foreach ( $worker->connections as $connection )
				{
					$connection->send ( time () );
				}
			} );
		};


		$http_worker->onMessage = function ( $connection , $data )
		{
			$connection->send ( 'hello world' . $data );
		};

		worker::runAll ();


	}
}
