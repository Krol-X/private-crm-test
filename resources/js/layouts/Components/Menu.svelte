<script>
  import MenuLink from '@/Layouts/Components/MenuLink.svelte'
</script>

<div class="menu">
  <MenuLink text="Главная" href="/" />
  <MenuLink text="Заказы" href="/orders" />
  <MenuLink text="Тарифы" href="/tariffs" />
</div>

<style lang="scss">
  .menu {
    @apply flex w-full bg-gray-50;
  }
</style>
