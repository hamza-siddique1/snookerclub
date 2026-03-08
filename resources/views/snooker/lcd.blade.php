<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&amp;family=Rajdhani:wght@500;600;700&amp;display=swap" rel="stylesheet">
    -->
    <title>Player Website</title>
    <!-- <script src="/assets/front/js/remote-lcd/remote.js"></script> -->
    <link rel="stylesheet" href="/assets/front/css/remote-lcd/remote.css">
  </head>
  <body cz-shortcut-listen="true">
    <div id="app">
      <div class=" flex flex-col">
        <header class="fixed top-0 left-0 right-0 z-50 bg-gray-900 shadow-sm border-b border-gray-800">
          <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
              <a class="text-xl font-semibold text-white hover:text-gray-300" href="/" data-discover="true">
                <img alt="Logo" class="h-8" src="/assets/front/images/logo.png">
              </a>
              <button class="md:hidden text-gray-300 hover:text-white focus:outline-none" aria-label="Toggle menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
              </button>
            </div>
          </nav>
        </header>
        <main class="flex-1 pt-16">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-center p-4">
              <div class="w-full max-w-5xl font-['Oswald',sans-serif]">
                <div class="rounded-2xl overflow-hidden border border-white/10 bg-[#0a0e0a] shadow-2xl">
                  <snooker-lcd :match="{{ json_encode($match) }}"></snooker-lcd>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script src="{{ mix('js/app.js') }}?time={{time()}}"></script>
  </body>
</html>
