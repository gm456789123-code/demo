  <!-- FOOTER -->
  <footer class="mt-14 text-white" style="background:#13357a;">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-3 text-sm">
      <p class="text-blue-100">&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. สงวนลิขสิทธิ์ทุกประการ</p>
      <nav class="flex flex-wrap items-center justify-center gap-5 text-blue-100">
        <a href="#" class="hover:text-white">เกี่ยวกับเรา</a>
        <a href="#" class="hover:text-white">ติดต่อเรา</a>
        <a href="#" class="hover:text-white">นโยบายความเป็นส่วนตัว</a>
        <a href="#" class="hover:text-white">เงื่อนไขการใช้งาน</a>
      </nav>
      <div class="flex items-center gap-4">
        <a href="#" class="hover:text-white">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 21v-7.5h2.4l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.3C16.3 4.2 15.4 4.1 14.3 4.1c-2.4 0-4 1.46-4 4.14v2.36H7.9v3h2.4V21h3.2z"/></svg>
        </a>
        <a href="#" class="hover:text-white">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="6" width="18" height="12" rx="3"/><polygon points="10,9.5 10,14.5 15,12" fill="currentColor" stroke="none"/></svg>
        </a>
        <a href="#" class="hover:text-white">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="15" r="3"/><path d="M13 4v10"/><path d="M13 4c0 2.5 2 4 4 4"/></svg>
        </a>
        <a href="#" class="hover:text-white">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
        </a>
      </div>
    </div>
  </footer>

<?php wp_footer(); ?>
</body>
</html>
