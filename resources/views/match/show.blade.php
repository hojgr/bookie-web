@extends('app')

@section('content')
	<div class="matchbox">
		<div class="team1">
			<div class="logo">
				{!! LogoUtil::renderBig($match->teams[0]) !!}
			</div>
			<div class="info">
				<div class="team-name">{{ (strlen($match->teams[0]->name) > 10) ? $match->teams[0]->short_name: $match->teams[0]->name }}</div>
				<div class="odds">50%</div>
			</div>
		</div>

		<div class="organization">
			{!! LogoUtil::renderSpecial($match->organization, 100) !!}
		</div>

		<div class="team2">
			<div class="logo">
				{!! LogoUtil::renderBig($match->teams[1]) !!}
			</div>

			<div class="info">
				<div class="team-name">{{ (strlen($match->teams[1]->name) > 10) ? $match->teams[1]->short_name: $match->teams[1]->name }}</div>
				<div class="odds">50%</div>
			</div>
		</div>
		<div style="clear: both"></div>

		<div class="details">
			<div class="time-from-now">{{ TimeUtil::formatTimestampFromNow($match->start) }}</div>
			<div class="bo-style"><span>Best of {{ $match->bo }}</span></div>
			<div class="time-start">{{ TimeUtil::formatTimestamp($match->start) }}</div>
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
    <div class="bet-locked">
        <h1>Bet Locked</h1>
        <h3>Total Value: $5.93</h3>
    </div>
    <div class="bet">
        <h3>Your bet:</h3>

		@for($i=0; $i<10; $i++)
        	<div class="itembox" data-contains="empty">Empty</div>
		@endfor
    </div>


	<div class="inventory">
        <h3>Your inventory:</h3>
        <div class="itembox">
            <div class="stattrak">ST</div>
            <div class="price">$0.00</div>
            <div class="image">
                <img src="https://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSZw3qtdfPNrR5ZNwdSpbSUqXVNQz4vktr0aUPK5bYp37m2yntbG0MCkD1ujVTR3uA_-U/90fx60f" />
            </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSZw3qtdfPNrR5ZNwdSpbSUqXVNQz4vktr0aUPK5bYp37m2yntbG0MCkD1ujVTR3uA_-U/90fx60f" />
                </div>
                <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
        <div class="itembox">
            <div class="stattrak">ST</div>
                <div class="price">$0.00</div>
                <div class="image">
                    <img src="https://steamcommunity-a.akamaihd.net/economy/image/Oopn2-pcvWM3ClBZPQNmE4LGrWquLLMj48SDQ9nlLrTzgVAgs0D7cZfTTKcbYzqdmsH2Laczsyflz4RR2PM5vvzDRCqiRPx4h6JIrRgpKYye170142b9PunOtUOcom2O8Zl_Lq8RvkuQkk26FxM2iI7brHe6YvgqvsLYEc_zaLSljxJ79BKxJZDES_0ULT-L2YTof6YypHizwokXlrgqv_U=/90fx60f" />
                </div>
            <div class="wear mw">Minimum Wear</div>
        </div>
    </div>
@endsection