@extends('app')

@section('content')
	<div class="matchbox">
		<div class="team1">
			<img height="75px" src="{{ asset('images/teams/virtus.pro.png') }}" />
			<div class="team-name">Virtus.pro</div>
		</div>
		<div class="team2">
			<div class="team-name">Cloud 9</div>
			<img height="75px" src="{{ asset('images/teams/cloud_9.png') }}" />
		</div>
	</div>
	<div class="streambox">
		<iframe src="http://www.twitch.tv/suchCow/embed" frameborder="0" scrolling="no" height="378" width="620"></iframe>
	</div>
	<div class="chatbox">
		<iframe src="http://www.twitch.tv/suchCow/chat?popout=" frameborder="0" scrolling="no" height="500" width="620"></iframe>
	</div>
@endsection

@section('rightside')
    <div class="bet">
        <h3>Your bet:</h3>
        <div class="itembox"><img src="https://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSZw3qtdfPNrR5ZNwdSpbSUqXVNQz4vktr0aUPK5bYp37m2yntbG0MCkD1ujVTR3uA_-U/99fx66f" /></div>
        <div class="itembox"><img src="https://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSZw3qtdfPNrR5ZNwdSpbSUqXVNQz4vktr0aUPK5bYp37m2yntbG0MCkD1ujVTR3uA_-U/99fx66f" /></div>
        <div class="itembox"><img src="https://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSZw3qtdfPNrR5ZNwdSpbSUqXVNQz4vktr0aUPK5bYp37m2yntbG0MCkD1ujVTR3uA_-U/99fx66f" /></div>
        <div class="itembox">Empty</div>
        <div class="itembox">Empty</div>
        <div class="itembox">Empty</div>
        <div class="itembox">Empty</div>
        <div class="itembox">Empty</div>
        <div class="itembox">Empty</div>
        <div class="itembox">Empty</div>
    </div>
@endsection