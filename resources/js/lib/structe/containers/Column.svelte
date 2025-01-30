<script>
  let { children, class: className = '', style: styleName = '', click } = $props();
</script>

<!-- svelte-ignore a11y_click_events_have_key_events, a11y_no_static_element_interactions -->
<div class={'flex flex-col ' + className} onclick={click} style={styleName}>
  {@render children?.()}
</div>
