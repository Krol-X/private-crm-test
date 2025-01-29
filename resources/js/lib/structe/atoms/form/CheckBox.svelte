<script>
  import { getContext } from 'svelte';
  const context = getContext('context');

  let {
    class: className = '',
    style: styleName = '',
    controlClass = '',
    controlStyle = '',
    name = '',
    value = '',
    checked = $bindable(),
    children,
    after = null
  } = $props();
</script>

<div class={className} style={styleName}>
  {#if children}
    <div>{@render children()}</div>
  {/if}

  {#if checked === undefined && context}
    <input
      type="checkbox"
      class={controlClass}
      style={controlStyle}
      {name}
      {value}
      bind:checked={context[name]}
    />
  {:else}
    <input
      type="checkbox"
      class={controlClass}
      style={controlStyle}
      {name}
      {value}
      bind:checked
    />
  {/if}

  {#if after}
    <div>{@render after()}</div>
  {/if}
</div>
