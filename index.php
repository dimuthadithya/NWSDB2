<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>National Water Supply and Drainage Board | Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      rel="shortcut icon"
      href="./assets/images/favicon.png"
      type="image/x-icon"
    />
  </head>
  <body class="min-h-screen bg-white">
    <div class="min-h-screen flex">
      <!-- Left Side - Logo -->
      <div
        class="hidden lg:flex flex-1 items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-700"
      >
        <div class="text-center">
          <div class="w-full mb-8">
            <!-- Full width logo image -->
            <div
              class="w-full bg-white backdrop-blur-sm shadow-xl overflow-hidden py-6 px-12"
            >
              <img
                src="assets/images/logo.png"
                alt="NWSDB Logo"
                class="w-full h-auto max-h-48 object-contain mx-auto"
              />
            </div>
          </div>
          <h1 class="text-4xl font-bold text-white mb-4">DEVICE RECORD</h1>
          <p class="text-xl text-blue-100 mb-2">SYSTEM</p>
          <p class="text-xl text-blue-100">Monaragala</p>
          <div class="mt-8 text-blue-200">
            <p class="text-sm">Managing Device Records</p>
            <p class="text-sm">Monaragala District</p>
          </div>
        </div>
      </div>

      <!-- Right Side - Login Form -->
      <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
          <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
              DEVICE RECORD SYSTEM
            </h2>
            <p class="mt-2 text-center text-lg font-medium text-gray-600">
              Monaragala
            </p>
          </div>
          <form class="mt-8 space-y-6">
            <div class="rounded-md space-y-4">
              <div>
                <label
                  for="username"
                  class="block text-sm font-medium text-gray-700 mb-2"
                >
                  Username
                </label>
                <input
                  id="username"
                  name="username"
                  type="text"
                  required
                  class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                  placeholder="Enter your username"
                />
              </div>
              <div>
                <label
                  for="password"
                  class="block text-sm font-medium text-gray-700 mb-2"
                >
                  Password
                </label>
                <input
                  id="password"
                  name="password"
                  type="password"
                  required
                  class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                  placeholder="Enter your password"
                />
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input
                  id="remember-me"
                  name="remember-me"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label
                  for="remember-me"
                  class="ml-2 block text-sm text-gray-900"
                >
                  Remember me
                </label>
              </div>
              <div class="text-sm">
                <a
                  href="#"
                  class="font-medium text-blue-600 hover:text-blue-500"
                >
                  Forgot your password?
                </a>
              </div>
            </div>

            <div>
              <button
                type="submit"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out cursor-pointer"
              >
                <span>
                  <i
                    class="fas fa-lock h-5 w-5 text-blue-500 group-hover:text-blue-400"
                  ></i>
                  Sign in
                </span>
              </button>
            </div>

            <div class="text-center">
              <p class="text-sm text-gray-600">
                Don't have an account?
                <a
                  href="register.html"
                  class="font-medium text-blue-600 hover:text-blue-500"
                >
                  Register here
                </a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Mobile Logo (shown on smaller screens) -->
    <div class="lg:hidden fixed top-4 right-4">
      <div
        class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg overflow-hidden"
      >
        <img
          src="assets/images/logo.png"
          alt="NWSDB Logo"
          class="w-8 h-8 object-contain"
        />
      </div>
    </div>
  </body>
</html>
