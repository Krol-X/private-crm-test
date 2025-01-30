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
    before = null
  } = $props();
</script>

<div class={`flex flex-row gap-2 items-center ${className}`} style={styleName}>
  {#if before}
    <div>{@render before()}</div>
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

  {#if children}
    <div>{@render children()}</div>
  {/if}
</div>

<style>
  input {
    width: 1rem;
    height: 1rem;
  }
</style>