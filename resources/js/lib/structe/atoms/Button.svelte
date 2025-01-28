<script>
  import { getContext } from 'svelte';
  const context = getContext('context');

  let {
    children,
    class: className = '',
    style: styleName = '',
    click = (e, context) => {}
  } = $props();
</script>

<button class={className} style={styleName} onclick={(e) => click(e, context)}>
  {@render children?.()}
</button>
