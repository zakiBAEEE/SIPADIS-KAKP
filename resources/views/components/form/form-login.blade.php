 <div
     class="flex flex-col justify-center px-6 py-12 lg:px-8 bg-white  w-5/6 sm:w-1/2 md:w-2/3 lg:w-1/3 rounded-xl shadow-lg">
     <div class="sm:mx-auto sm:w-full sm:max-w-sm">
         <img class="mx-auto h-24 w-auto" src={{ asset('images/logo-lldikti.jpg') }} alt="Your Company">
         <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
     </div>
     <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
         <form class="space-y-6" method="POST" action="{{ route('login') }}">
             @csrf
             <div>
                 <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
                 <div class="mt-2">
                     <input type="text" name="username" id="username" required
                         class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                     {{-- Menampilkan error untuk field 'username' --}}
                     @error('username')
                         <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                     @enderror
                 </div>
             </div>
             <div>
                 <div class="flex items-center justify-between">
                     <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                 </div>
                 <div class="mt-2">
                     <input type="password" name="password" id="password" autocomplete="current-password" required
                         class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                     {{-- Menampilkan error untuk field 'password' --}}
                     @error('password')
                         <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                     @enderror
                 </div>
             </div>

             <div>
                 <button type="submit"
                     class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Masuk</button>
             </div>
         </form>
     </div>
 </div>
