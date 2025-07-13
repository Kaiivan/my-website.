<?php
session_start();
include 'partials.php';
?>

<section class="max-w-md mx-auto my-12 bg-white p-8 rounded-lg shadow">
  <h2 class="text-3xl font-bold mb-6 text-center">Masuk ke Akun</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
      Username atau Password salah!
    </div>
  <?php endif; ?>

  <form action="proses_login.php" method="POST" class="space-y-4">
    <input type="text" name="username" placeholder="Username" required class="w-full p-3 border border-gray-300 rounded-md" />
    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-md" />
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Masuk</button>
  </form>

  <p class="text-center text-sm mt-4">Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Daftar di sini</a></p>
</section>

<?php include 'footer.php'; ?>
