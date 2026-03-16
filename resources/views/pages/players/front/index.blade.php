<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,900&amp;display=swap">
    <title>Player | SnookernPool</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front') }}/images/logo.jpeg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&amp;family=Rajdhani:wght@500;600;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/front/css/player/style.css') }}" >
</head>

<body cz-shortcut-listen="true">
  <div id="root">
    <div class="PlayerLayout bg-black/80 text-white font-sans min-h-screen flex flex-col relative">
      <div class="hidden md:block absolute inset-0 z-0 bg-no-repeat pointer-events-none" aria-hidden="true" style="background-image: url('{{ asset('players/' . $player->image1) }}'); background-size: contain; background-position: right top;"></div>
      <div class="relative z-10 flex flex-col flex-1">
        <div class="px-4 sm:px-6 xl:px-8 py-2">
          <a class="text-xl font-semibold text-white hover:text-gray-300" href="/" data-discover="true">
            <img alt="Logo" class="h-8" src="{{ asset('assets/front') }}/images/logo.jpeg">
          </a>
        </div>
        <div class="flex min-h-screen flex-1">
          <main class="flex-1 overflow-auto ">
            <div class="min-h-screen text-white font-sans ">
              <section class="relative overflow-hidden">
                <div class="hidden md:flex absolute right-16 bottom-20 z-5 select-none items-end gap-0">
                  <span class="text-[250px] xl:text-[400px] text-white/80 leading-none scale-y-110"></span>
                  <div class="flex -ml-4 items-end absolute bottom-0 right-6">
                    <img alt="France" class="w-10 h-10 rounded-full object-cover border-2 border-white/20 relative z-10" src="https://cdn.countryflags.com/thumbs/france/flag-round-250.png">
                  </div>
                </div>
               <div class="relative z-20 py-6 px-4 sm:px-6 xl:px-8 xl:pl-20 xl:py-10">
                  <!-- Player Image (Mobile) -->
                  @if($player->image1)
                      <div class="md:hidden w-full max-h-[200px] mb-6 overflow-hidden rounded-lg">
                          <img alt="{{ $player->name }}" class="w-full max-h-[400px] object-contain" src="{{ asset('players/' . $player->image1) }}">
                      </div>
                  @endif

                  <!-- Player Name -->
                  <div class="mb-6 sm:mb-8">
                      <p class="text-[18px] font-bold text-zinc-400 tracking-wide mb-1">{{ $player->name }}</p>
                      <h1 class="text-4xl sm:text-5xl xl:text-6xl font-black tracking-tight leading-none">{{ $player->name }}</h1>
                  </div>

                  @include('pages.players.front._inc.basic_info')
                </div>
              </section>
              <div class="flex flex-col xl:flex-row gap-6 px-4 sm:px-6 xl:px-8 pb-10">
                <div class="flex-1 min-w-0 bg-black rounded-t overflow-hidden">
                  <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 p-4 bg-white/10 relative">
                    <h2 class="text-[14px] tracking-[0.2em] text-zinc-400 font-semibold uppercase shrink-0">Appearances</h2>
                    <div class="flex items-center gap-2 overflow-x-auto flex-1">
                      <button type="button" class="px-4 py-1.5 text-[16px] font-medium rounded-[90px] transition-colors cursor-pointer whitespace-nowrap bg-black text-white">8 Pool</button>
                      <button type="button" class="px-4 py-1.5 text-[16px] font-medium rounded-[90px] transition-colors cursor-pointer whitespace-nowrap text-zinc-500 hover:text-zinc-300">Snooker</button>
                    </div>
                    <div class="absolute right-4">
                      <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a2744] hover:bg-[#243352] transition-colors cursor-pointer shrink-0">
                        <svg class="w-3.5 h-3.5 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h6v6M9 21H3v-6M21 3l-8 8M3 21l8-8"></path>
                        </svg>
                      </button>
                    </div>
                  </div>

                    @include('pages.players.front._inc.recent_matches')

                </div>
                <div class="w-full xl:w-72 xl:shrink-0 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-6 ">
                  <div class="bg-black rounded-md border border-zinc-800/60 overflow-hidden">
                    <div class="flex items-center justify-between bg-white/10 px-5 py-4 h-[68px]">
                      <h3 class="text-[14px] tracking-[0.2em] text-zinc-400 font-semibold uppercase">Market Value</h3>
                      <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a2744] hover:bg-[#243352] transition-colors cursor-pointer shrink-0">
                        <svg class="w-3.5 h-3.5 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h6v6M9 21H3v-6M21 3l-8 8M3 21l8-8"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="p-5">
                      <p class="text-[10px] tracking-widest text-zinc-500 uppercase mb-1">Current Market Value</p>
                      <div class="flex items-baseline gap-1 mb-3">
                        <span class="text-4xl font-black text-amber-400">180</span>
                        <span class="text-2xl font-bold text-amber-400">M</span>
                        <span class="text-lg text-amber-400/70">€</span>
                      </div>
                      <div class="mb-5">
                        <p class="text-[10px] tracking-widest text-zinc-500 uppercase">Last Update</p>
                        <p class="text-[14px] font-semibold text-white">Oct 24, 2018</p>
                      </div>
                      <div>
                        <svg viewBox="0 0 220 70" class="w-full" preserveAspectRatio="none" style="height: 80px;">
                          <defs>
                            <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                              <stop offset="0%" stop-color="#facc15" stop-opacity="0.3"></stop>
                              <stop offset="100%" stop-color="#facc15" stop-opacity="0.02"></stop>
                            </linearGradient>
                          </defs>
                          <polygon points="0,70 0,70 27.5,58.333333333333336 55,46.66666666666667 82.5,35 110,23.333333333333336 137.5,11.666666666666664 165,0 192.5,2.916666666666657 220,0 220,70" fill="url(#areaGrad)"></polygon>
                          <polyline points="0,70 27.5,58.333333333333336 55,46.66666666666667 82.5,35 110,23.333333333333336 137.5,11.666666666666664 165,0 192.5,2.916666666666657 220,0" fill="none" stroke="#facc15" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></polyline>
                          <circle cx="0" cy="70" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="27.5" cy="58.333333333333336" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="55" cy="46.66666666666667" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="82.5" cy="35" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="110" cy="23.333333333333336" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="137.5" cy="11.666666666666664" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="165" cy="0" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="192.5" cy="2.916666666666657" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                          <circle cx="220" cy="0" r="4" fill="#0a1428" stroke="#facc15" stroke-width="2"></circle>
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div class="bg-black rounded-lg border border-zinc-800/60 overflow-hidden">
                    <div class="flex items-center justify-between bg-white/10 px-5 py-4 h-[68px]">
                      <div class="flex items-center gap-2">
                        <h3 class="text-[14px] tracking-[0.2em] text-zinc-400 font-semibold uppercase">Statistics</h3>
                        <select class="text-[12px] text-zinc-500 bg-transparent border-none outline-none cursor-pointer appearance-none pr-4" style="background-image: url(&quot;data:image/svg+xml,%3Csvg
																																xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2371717a' stroke-width='2'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right center;">
                          <option value="2018" selected="">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                        </select>
                      </div>
                      <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a2744] hover:bg-[#243352] transition-colors cursor-pointer shrink-0">
                        <svg class="w-3.5 h-3.5 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h6v6M9 21H3v-6M21 3l-8 8M3 21l8-8"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="p-5">
                      <div class="mb-6">
                        <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                          <div class="swiper-wrapper">
                            <div class="swiper-slide swiper-slide-active" style="width: auto; margin-right: 16px;">
                              <button type="button" class="text-[14px] whitespace-nowrap px-4 py-1.5 font-medium rounded-full transition-colors cursor-pointer bg-black text-white">8 Pool</button>
                            </div>
                            <div class="swiper-slide swiper-slide-next" style="width: auto; margin-right: 16px;">
                              <button type="button" class="text-[14px] whitespace-nowrap px-4 py-1.5 font-medium rounded-full transition-colors cursor-pointer text-zinc-500 hover:text-zinc-300">Snooker</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="flex items-end gap-4 justify-between">
                        <span class="text-6xl font-black text-amber-400 ">38 41</span>
                        <div class="pb-1 font-bold">
                          <p class="text-[10px] tracking-[0.15em] text-zinc-500 uppercase leading-relaxed">Total</p>
                          <p class="text-[10px] tracking-[0.15em] text-zinc-500 uppercase leading-relaxed">Games</p>
                          <p class="text-[10px] tracking-[0.15em] text-zinc-500 uppercase leading-relaxed">Played</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>
  </div>
  </script>
</body>
</html>

