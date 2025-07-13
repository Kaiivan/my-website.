<?php include 'partials.php'; ?>

<section class="max-w-md mx-auto my-12 bg-white p-8 rounded-lg shadow">
  <h2 class="text-3xl font-bold mb-6 text-center">Daftar Akun Baru</h2>

  <form action="proses_register.php" method="POST" class="space-y-4">
    <input type="text" name="nama" placeholder="Nama Lengkap" required
      class="w-full p-3 border border-gray-300 rounded-md" />

    <input type="text" name="username" placeholder="Username" required
      class="w-full p-3 border border-gray-300 rounded-md" />

    <input type="password" name="password" placeholder="Password" required
      class="w-full p-3 border border-gray-300 rounded-md" />

    <button type="submit"
      class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Daftar</button>
  </form>

  <p class="text-center text-sm mt-4">
    Sudah punya akun?
    <a href="login.php" class="text-blue-500 hover:underline">Masuk di sini</a>
  </p>
</section>

<?php include 'footer.php'; ?>
