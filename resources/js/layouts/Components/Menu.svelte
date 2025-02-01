<script>
  const { event } = $props();

  import store from '@/store';

  import MenuItem from './MenuItem.svelte';
  import IconPlus from '~/assets/icon-plus-square-o.svelte';
</script>

<div class="menu">
  <MenuItem href="/orders">Заказы</MenuItem>
  <MenuItem href="/tariffs">Тарифы</MenuItem>
  <div class="flex-1"></div>
  <MenuItem click={() => store.events.dispatch('new-item')}>
    <IconPlus />
  </MenuItem>
</div>

<style lang="scss">
  .menu {
    @apply flex w-full bg-gray-50;
  }
</style>
