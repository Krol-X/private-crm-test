<script>
  let { children, class: className = '', style: styleName = '' } = $props();
</script>

<div class={'flex ' + className} style={styleName}>
  {@render children?.()}
</div>
