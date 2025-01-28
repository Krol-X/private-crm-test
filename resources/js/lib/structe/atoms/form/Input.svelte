<script>
  import { getContext } from 'svelte';
  const context = getContext('context');

  let {
    class: className = '',
    style: styleName = '',
    controlClass = '',
    controlStyle = '',
    name = '',
    type = 'text',
    value = $bindable(),
    children,
    after = null
  } = $props();

  function typeAction(node) {
    node.type = type;
  }
</script>

<div class={className} style={styleName}>
  {#if children}
    <div>{@render children()}</div>
  {/if}

  {#if value === undefined && context}
    <input
      class="w-full px-1 py-0 {controlClass}"
      style={controlStyle}
      use:typeAction
      {name}
      bind:value={context[name]}
    />
  {:else}
    <input
      class="w-full px-1 py-0 {controlClass}"
      style={controlStyle}
      use:typeAction
      {name}
      bind:value
    />
  {/if}

  {#if after}
    <div>{@render after()}</div>
  {/if}
</div>
