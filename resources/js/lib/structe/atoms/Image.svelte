<script>
  let { class: className = '', style: styleName = '', src = '#', alt = '' } = $props();
</script>

<img class={className} style={styleName} {src} {alt} />
