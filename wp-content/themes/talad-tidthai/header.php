<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  body { font-family: 'Noto Sans Thai', sans-serif; }
  .hero-gradient { background: linear-gradient(90deg, rgba(19,53,122,.55), rgba(19,53,122,.05)); }
  .stat-gradient { background: linear-gradient(90deg, #13357a 0%, #1d4ed8 55%, #1aa260 100%); }
  .scrollbar-none::-webkit-scrollbar { display: none; }
  .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-gray-50 text-gray-800' ); ?>>
<?php wp_body_open(); ?>

  <!-- top accent bar -->
  <div class="h-1.5 w-full" style="background: linear-gradient(90deg,#facc15,#1d4ed8,#1aa260);"></div>

  <!-- HEADER -->
  <header class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 h-20 flex items-center justify-between gap-4">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 shrink-0">
        <span class="w-10 h-10 rounded-xl flex items-center justify-center text-white" style="background:#13357a;">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l10 10-10 10L2 12 12 2z"/></svg>
        </span>
        <span>
          <span class="block text-lg font-extrabold leading-none" style="color:#13357a;"><?php bloginfo( 'name' ); ?></span>
          <span class="block text-xs text-gray-500 mt-0.5"><?php bloginfo( 'description' ); ?></span>
        </span>
      </a>

      <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold">
        <?php if ( has_nav_menu( 'primary' ) ) : ?>
          <?php
          wp_nav_menu( array(
              'theme_location' => 'primary',
              'container'      => false,
              'items_wrap'     => '%3$s',
              'link_before'    => '',
              'link_after'     => '',
          ) );
          ?>
        <?php else : ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="px-4 py-2 rounded-full text-white" style="background:#13357a;">หน้าหลัก</a>
          <a href="#" class="px-4 py-2 rounded-full text-gray-600 hover:bg-gray-100">ค้นหาที่ดิน</a>
          <a href="#" class="px-4 py-2 rounded-full text-gray-600 hover:bg-gray-100">เปรียบเทียบ</a>
          <a href="#" class="px-4 py-2 rounded-full text-gray-600 hover:bg-gray-100">ดูล่าสุด</a>
        <?php endif; ?>
      </nav>

      <div class="flex items-center gap-2 lg:gap-3 shrink-0">
        <button class="hidden md:flex items-center gap-1 px-3 py-2 rounded-full border border-gray-200 text-sm font-medium text-gray-600">
          TH <span class="text-xs">▾</span>
        </button>
        <a href="<?php echo esc_url( wp_login_url() ); ?>" class="hidden sm:inline-block px-4 py-2 rounded-full border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50">เข้าสู่ระบบ</a>
        <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="px-4 py-2 rounded-full text-sm font-semibold text-white" style="background:#1d4ed8;">สมัครสมาชิก</a>
      </div>
    </div>
  </header>
