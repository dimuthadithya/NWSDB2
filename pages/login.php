<?php
require_once __DIR__ . '/../middleware/auth.php';
guestOnly();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NWSDB | Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link
    rel="shortcut icon"
    href="./assets/images/favicon.png"
    type="image/x-icon" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.dots.min.js"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body
  class="relative min-h-screen flex items-center justify-center text-white">
  <a
    href="../index.html"
    class="fixed top-4 left-4 z-20 h-12 w-12 flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white hover:bg-white/20 transition"
    aria-label="Back to Home">
    <i class="fas fa-home"></i>
  </a>
  <div id="vanta-bg" class="absolute top-0 left-0 w-full h-full z-0"></div>
  <div
    class="relative z-10 flex w-full max-w-6xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl overflow-hidden mx-4 lg:mx-0">
    <!-- Left Info Section -->
    <div
      class="hidden lg:flex flex-1 bg-gradient-to-br from-blue-800/40 to-cyan-900/20 backdrop-blur-lg items-center justify-center p-12">
      <div class="text-center">
        <div class="bg-white/20 rounded-2xl p-6 mb-6 shadow-lg inline-block">
          <img
            src="../assets/images/logo.png"
            alt="NWSDB Logo"
            class="w-40 h-auto mx-auto" />
        </div>
        <h1 class="text-4xl font-bold mb-2">Hardware RECORD</h1>
        <p class="text-xl text-cyan-300 mb-1 tracking-wide">SYSTEM</p>
        <p class="text-xl text-cyan-300">Bandarawela</p>
        <div class="mt-6 text-cyan-200 text-sm space-y-1">
          <p>Managing Hardware Records</p>
          <p>Bandarawela District</p>
        </div>
      </div>
    </div>

    <!-- Right: Login Form -->
    <div
      class="flex-1 bg-gray-900/70 backdrop-blur-md p-8 lg:p-12 flex flex-col justify-center">
      <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-white mb-2">
          Sign In to Your Account
        </h2>
        <p class="text-gray-300">
          Welcome back! Please enter your credentials.
        </p>
      </div>

      <form class="space-y-6" action="../handlers/auth.php" method="POST">
        <div>
          <label
            for="email"
            class="block text-sm font-medium mb-2 text-gray-300">
            <i class="fas fa-envelope mr-2"></i>Email
          </label>
          <input
            id="email"
            name="email"
            type="email"
            required
            placeholder="your.email@example.com"
            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition" />
        </div>

        <div>
          <label
            for="password"
            class="block text-sm font-medium mb-2 text-gray-300">
            <i class="fas fa-lock mr-2"></i>Password
          </label>
          <input
            id="password"
            name="password"
            type="password"
            required
            placeholder="••••••••"
            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition" />
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center text-sm text-gray-300">
            <input
              type="checkbox"
              name="remember-me"
              class="h-4 w-4 text-cyan-500 border-gray-500 bg-transparent" />
            <span class="ml-2">Remember me</span>
          </label>
          <a href="#" class="text-sm text-cyan-400 hover:underline">Forgot your password?</a>
        </div>

        <div class="pt-2">
          <button
            type="submit"
            name="login"
            class="group w-full py-3 px-4 text-lg font-semibold rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-blue-500 hover:to-cyan-500 shadow-lg hover:shadow-cyan-500/40 text-white transition transform hover:scale-[1.02] flex justify-center items-center">
            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
          </button>
        </div>

        <div class="text-center pt-4 border-t border-white/10">
          <p class="text-sm text-gray-400">
            Don't have an account?
            <a href="./register.php" class="text-cyan-400 hover:underline">Register here</a>
          </p>
        </div>
      </form>
    </div>
  </div>

  <script>
    VANTA.DOTS({
      el: '#vanta-bg',
      mouseControls: true,
      touchControls: true,
      gyroControls: false,
      minHeight: 200.0,
      minWidth: 200.0,
      scale: 1.0,
      scaleMobile: 1.0,
      color: 0x00b4d8,
      backgroundColor: 0x001f3f,
      showLines: false,
    });
  </script>
</body>

</html>