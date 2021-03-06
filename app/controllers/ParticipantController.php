<?php

class ParticipantController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /participant
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /participant/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /participant
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /participant/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /participant/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /participant/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /participant/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($participant)
	{

		$user = 				Auth::user();
		$club = 				$user->clubs()->FirstOrFail();
		$participant = 	Participant::Find($participant);
		$player = 			Player::Find($participant->player->id);
		$user_parent = 	User::find($participant->accepted_user);
		$event =	 			Evento::find($participant->event->id);
		$uuid = 				Uuid::generate();

		//$amount = $payment->getOriginal('subtotal');
		$amount = Input::get('amount');

		if ($amount > 0 ) {

			$param = array(
				'transactionid'	=> $payment->transaction,
				'club' 					=> $club->id,
				'amount' 				=> number_format($amount,2,".","")
			);

			$transaction = $payment->refund($param);
			
			if($transaction->response == 3 || $transaction->response == 2 ){
				return Response::json($transaction);
				return Redirect::action('ParticipantController@delete', $event->id, $payment->id )->with('error',$transaction->responsetext);
			
			}else{
				
				$payment1 = new Payment;
				$payment1->id						= $uuid;
				$payment1->customer     = $user_parent->profile->customer_vault;
				$payment1->transaction  = $transaction->transactionid;	
				$payment1->subtotal 		= -$transaction->total;
				$payment1->total   			= -$transaction->total;
				$payment1->club_id			= $club->id;
				$payment1->user_id			= $user_parent->id;
				$payment1->player_id 		= $player->id;
				$payment1->event_type		= $event->type_id;
				$payment1->type					= $transaction->type;
				$payment1->save();

				$sale = new Item;
				$sale->description 	= $event->name . " ($transaction->type)" ;
				$sale->quantity 		= 1;
				$sale->price 				= -$transaction->total;
				$sale->payment_id   = $uuid;
				$sale->event_id   	= $event->id;
				$sale->save();

				

			}//end of transaction result

		} //end of amount test 
		
		$participant->delete();
		return Redirect::action('EventoController@show', $event->id);

	}

	public function delete($participant)
	{
		$user =Auth::user();
		$club = $user->clubs()->FirstOrFail();
		$participant = 	Participant::Find($participant);
		$player = Player::Find($participant->player_id);
		$event = Evento::find($participant->event->id);
		// $payment = Payment::find($payment);
		
		$title = 'League Together - '.$event->name.' Event';

		return View::make('app.club.event.participant.delete')
		->with('page_title', $title)
		->withEvent($event)
		->withClub($club)
		->withPlayer($player)
		->with('participant', $participant)
		// ->withPayment($payment)
		->withUser($user);
	}

}