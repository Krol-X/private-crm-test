<script>
  let { children, class: className = '', style: styleName = '' } = $props();
</script>

<div class={'flex flex-col ' + className} style={styleName}>
  {@render children?.()}
</div>
