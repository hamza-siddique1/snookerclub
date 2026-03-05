<html lang="en"><head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&amp;family=Rajdhani:wght@500;600;700&amp;display=swap" rel="stylesheet">
    <title>Leaderboard</title>
    <link href="/assets/front/css/rankings/style.css" rel="stylesheet">


  </head>
  <body>
    <div id="root">
  <div class=" flex flex-col">

    <main class="flex-1 pt-16">
      <div class=" mx-auto py-16 bg-stone-50 ">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 max-width-container gap-20 md:gap-x-4">
          <div class="relative flex flex-col w-full gap-1">

          <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[80px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-black">
                <p class="font-bold text-white text-3xs">1</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="TRUMP" class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[114px] h-[114px] " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>

@foreach($rankings as $ranking)
<section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">

  <!-- Rank Box -->
  <div class="position-container overflow-hidden flex h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative
      {{ $ranking['rank'] == 1 ? 'bg-black' : 'bg-red-700' }}">

      <p class="font-bold text-white text-3xs">
        {{ $ranking['rank'] }}
      </p>

  </div>

  <div class="flex items-center justify-between w-full h-full details-container">

    <div class="flex items-center h-full gap-2 player-details-wrapper">

      <div class="w-[122px] h-full self-start relative">
        <img
          alt="{{ $ranking['player']['name'] }}"
          class="h-full mx-auto"
          src="players/{{ $ranking['player']['ranking_image'] }}"
        >
      </div>

      <div class="player-name-wrapper">
        <p class="font-bold text-[12px] text-gray-400">
          {{ explode(' ', $ranking['player']['name'])[0] }}
        </p>
        <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">
          {{ explode(' ', $ranking['player']['name'])[1] ?? '' }}
        </p>
      </div>

    </div>

    <div class="flex">
      <p class="font-bold text-[14px] text-gray-900">
        {{ $ranking['score'] }}
      </p>
    </div>

  </div>
</section>
@endforeach

            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">2</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="WILSON" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/50d628c0-9c3b-11ee-98cf-47093ad7aceb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">3</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="ROBERTSON" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/bc92b5a0-9b7e-11ee-b817-916de7e0a6fb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">4</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="WILLIAMS" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/da72f9f0-125e-11f1-b61b-4ba2cf780879.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">5</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="XINTONG" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">6</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="HIGGINS" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">7</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="SELBY" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">8</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="MURPHY" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">9</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="HAWKINS" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
            <section class="flex w-full items-center rounded-[8px] pr-4 mb-1 group relative player-rankings-card light bg-white h-[56px]">
              <div class="position-container overflow-hidden flex  h-full w-[40px] rounded-tl-[8px] rounded-bl-[8px] items-center justify-center relative bg-red-700">
                <p class="font-bold text-white text-3xs">10</p>
              </div>
              <div class="flex items-center justify-between w-full h-full details-container">
                <div class="flex items-center h-full gap-2  player-details-wrapper">
                  <div class="w-[122px] h-full self-start relative">
                    <img alt="GUODONG" class="h-full mx-auto " src="https://images.gc.wstservices.co.uk/600x600/b217a330-9b95-11ee-a374-adc81d8d39cb.png">
                  </div>
                  <div class="player-name-wrapper">
                    <p class="font-bold text-[12px] text-gray-400">Kyren</p>
                    <p class="text-[14px] font-bold tracking-wide uppercase text-gray-900 font-primary">Wilson</p>
                  </div>
                </div>
                <div class="flex">
                  <p class="font-bold text-[14px] text-gray-900">£1,374,600</p>
                </div>
              </div>
            </section>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>

</body></html>
