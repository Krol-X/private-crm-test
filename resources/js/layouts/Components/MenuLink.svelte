<script>
  import { inertia, page } from '@inertiajs/svelte'

  export let text
  export let href

  $: is_active = $page.url.endsWith(href)
</script>

<a use:inertia class="menulink" class:active={is_active} {href}>{text}</a>

<style lang="scss">
  .menulink {
    @apply select-none;
    @apply px-3 sm:px-4 py-2 flex items-center hover:bg-slate-200;

    font-size: clamp(0.75rem, 2.5vw, 1rem);
  }

  .menulink.active::after {
    @apply bg-red-600;
    transform: scaleX(1);
    transform-origin: bottom left;
  }
</style>
