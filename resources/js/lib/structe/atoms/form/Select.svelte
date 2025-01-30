<script>
  import { getContext } from 'svelte';

  const context = getContext('context');

  let {
    class: className = '',
    style: styleName = '',
    controlClass = '',
    controlStyle = '',
    name = '',
    value = $bindable(),
    children,
    after = null,
    options = []
  } = $props();
</script>

<div class={className} style={styleName}>
  {#if children}
    <div class="mb-1">{@render children()}</div>
  {/if}

  {#if value === undefined && context}
    <select
      class="w-full px-1 py-0 border rounded {controlClass}"
      style={controlStyle}
      bind:value={context[name]}
    >
      {#each options as option}
        <option value={option.value} selected={option.value === value}>
          {option.label}
        </option>
      {/each}
    </select>
  {:else}
    <select
      class="w-full px-1 py-0 border rounded {controlClass}"
      style={controlStyle}
      bind:value={value}
    >
      {#each options as option}
        <option value={option.value} selected={option.value === value}>
          {option.label}
        </option>
      {/each}
    </select>
  {/if}

  {#if after}
    <div class="mt-1">{@render after()}</div>
  {/if}
</div>
