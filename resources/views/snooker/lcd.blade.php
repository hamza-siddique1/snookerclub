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
    <link rel="stylesheet" href="/assets/front/css/lcd/lcd.css">
  </head>
  <body cz-shortcut-listen="true">
    <div id="app">
      <div class="layout-root">
        <main class="layout-main">
          <div class="page-container-score">
            <div class="score-root">
              <div class="score-container">
                <div class="score-table-wrapper">
                  <snooker-lcd :match="{{ json_encode($match) }}"></snooker-lcd>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
