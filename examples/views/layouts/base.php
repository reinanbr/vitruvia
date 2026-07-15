<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>{title}</title>
</head>

<body>
  <nav class="navbar navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="/">Vitruvia</a>
      <span class="navbar-text">{navbar}</span>
    </div>
  </nav>

  <main class="container my-4">
    {{content}}
  </main>

  <footer class="text-center text-muted py-3">
    <p>Built with Vitruvia</p>
  </footer>
</body>

</html>
