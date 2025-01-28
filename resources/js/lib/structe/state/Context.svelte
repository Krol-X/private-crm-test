<script>
  import { setContext } from 'svelte';
  let { children, context = $bindable({}) } = $props();
  setContext('context', context);
</script>

{@render children()}
