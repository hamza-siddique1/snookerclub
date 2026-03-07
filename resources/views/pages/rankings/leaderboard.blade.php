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
                      src="storage/{{ $ranking['player']['ranking_image'] }}"
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
          </div>

        </div>
      </div>
    </main>
  </div>
</div>

</body>
</html>
