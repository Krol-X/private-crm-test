<script>
  import { inertia, page } from '@inertiajs/svelte';

  const {
    children,
    class: className = '',
    style: styleName = '',
    href,
    click
  } = $props();

  let is_active = $derived($page.url.endsWith(href));
</script>

{#if href}
  <a use:inertia class={`menu-item ${className}`} style={styleName} class:active={is_active} {href} onclick={click}>
    {@render children?.()}
  </a>
{:else}
  <button class={`menu-item ${className}`} style={styleName} onclick={click}>
    {@render children?.()}
  </button>
{/if}


<style lang="scss">
  .menu-item {
    @apply select-none;
    @apply px-3 sm:px-4 py-2 flex items-center hover:bg-slate-200;

    font-size: clamp(0.75rem, 2.5vw, 1rem);
  }

  .menu-item.active::after {
    @apply bg-red-600;
    transform: scaleX(1);
    transform-origin: bottom left;
  }
</style>
