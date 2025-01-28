<script>
  let { children, class: className = '', style: styleName = '' } = $props();
</script>

<div class={className} style={styleName}>
  {@render children?.()}
</div>
