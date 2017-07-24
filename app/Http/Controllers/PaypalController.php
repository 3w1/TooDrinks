<?php 
 
namespace App\Http\Controllers;
 
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
 
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
 
use App\Order;
use App\OrderItem; 

use App\Models\Impresion_Banner;
 
class PaypalController extends BaseController
{
	private $_api_context;
 
	public function __construct()
	{
		// setup PayPal api context
		$paypal_conf = \Config::get('paypal');
		$this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
		$this->_api_context->setConfig($paypal_conf['settings']);
	}
 
	public function postPayment(Request $request)
	{
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
 
		$items = array();
		$currency = 'USD';
 
		$item = new Item();
		
		if ($request->tipo == 'Banner'){
			$datosImpresion = Impresion_Banner::find($request->impresion_id)->first();

			$descripcion = "Publicación de su Banner ".$datosImpresion->banner->titulo." por ".$datosImpresion->tiempo_publicacion." Días";
			$item->setName('Publicidad')
				 ->setCurrency($currency)
				 ->setDescription($descripcion)
				 ->setQuantity(1)
				 ->setPrice($request->precio);

			\Session::put('tipo', 'Banner');
			\Session::put('impresion_id', $request->impresion_id);
			
		}elseif ($request->tipo == 'Plan'){
			$item->setName($request->plan)
				 ->setCurrency($currency)
				 ->setDescription($request->descripcion)
				 ->setQuantity(1)
				 ->setPrice($request->precio);

			\Session::put('tipo', 'Plan');
			\Session::put('plan_id', $request->id);
		}
 		
 		$items[] = $item;
		$total = $request->precio;

		$item_list = new ItemList();
		$item_list->setItems($items);
 
		$amount = new Amount();
		$amount->setCurrency($currency)
			->setTotal($total);
 
		$transaction = new Transaction();
		if ($request->tipo == 'Banner'){
			$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription("Prueba");
		}elseif ($request->tipo == 'Plan'){
			$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription('Pagar Plan de Crédito TooDrink');
		}
 
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(\URL::route('payment.status'))
			->setCancelUrl(\URL::route('payment.status'));
 
		$payment = new Payment();
		$payment->setIntent('Sale')
			->setPayer($payer)
			->setRedirectUrls($redirect_urls)
			->setTransactions(array($transaction));
 
		try {
			$payment->create($this->_api_context);
		} catch (\PayPal\Exception\PPConnectionException $ex) {
			if (\Config::get('app.debug')) {
				echo "Exception: " . $ex->getMessage() . PHP_EOL;
				$err_data = json_decode($ex->getData(), true);
				exit;
			} else {
				die('Ups! Algo salió mal');
			}
		}
 
		foreach($payment->getLinks() as $link) {
			if($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
				break;
			}
		}
 
		// add payment ID to session
		\Session::put('paypal_payment_id', $payment->getId());
 
		if(isset($redirect_url)) {
			// redirect to paypal
			return \Redirect::away($redirect_url);
		}
 
		return \Redirect::route('cart-show')
			->with('message', 'Ups! Error desconocido.');
 
	}
 
	public function getPaymentStatus()
	{
		// Get the payment ID before session clear
		$payment_id = \Session::get('paypal_payment_id');
		$tipo = \Session::get('tipo');
		if ($tipo == 'Banner'){
			$impresion_id = \Session::get('impresion_id');
			\Session::forget('impresion_id');
		}elseif ($tipo == 'Plan'){
			$plan_id = \Session::get('plan_id');
 			\Session::forget('plan_id');
		}
		
		// clear the session payment ID
		\Session::forget('paypal_payment_id');
		\Session::forget('tipo');
 
		$payerId = \Input::get('PayerID');
		$token = \Input::get('token');
 
		if (empty($payerId) || empty($token)) {
			return \Redirect::route('home')
				->with('message', 'Hubo un problema al intentar pagar con Paypal');
		}
 
		$payment = Payment::get($payment_id, $this->_api_context);
 
		$execution = new PaymentExecution();
		$execution->setPayerId(\Input::get('PayerID'));
 
		$result = $payment->execute($execution, $this->_api_context);
 
 
		if ($result->getState() == 'approved') {
 
			//$this->saveOrder();
 
			\Session::forget('cart');
			if ($tipo == 'Banner'){
				return redirect('banner-publicitario/confirmar-pago/'.$impresion_id);
			}elseif ($tipo == 'Plan'){
				return redirect('credito/compra/'.$plan_id);
			}
		}
		/*return \Redirect::route('home')
			->with('message', 'La compra fue cancelada');*/
		dd("La compra fue cancelada");
	}
 
	protected function saveOrder()
	{
		$subtotal = 0;
		$cart = \Session::get('cart');
		$shipping = 100;
 
		foreach($cart as $producto){
			$subtotal += $producto->quantity * $producto->price;
		}
 
		$order = Order::create([
			'subtotal' => $subtotal,
			'shipping' => $shipping,
			'user_id' => \Auth::user()->id
		]);
 
		foreach($cart as $producto){
			$this->saveOrderItem($producto, $order->id);
		}
	}
 
	protected function saveOrderItem($producto, $order_id)
	{
		OrderItem::create([
			'price' => $producto->price,
			'quantity' => $producto->quantity,
			'product_id' => $producto->id,
			'order_id' => $order_id
		]);
	}
}