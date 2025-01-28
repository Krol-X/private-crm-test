<script>
  let {
    class: className = '',
    style: styleName = '',
    classItem = '',
    styleItem = '',
    data,
    item: Item
  } = $props();

  import { isFunction } from '../utils/types';
</script>

<div class={className} style={styleName}>
  {#each data as itemData}
    {#if isFunction(Item)}
      {@render Item(itemData, classItem, styleItem)}
    {:else}
      <Item data={itemData} class={classItem} style={styleItem} />
    {/if}
  {/each}
</div>
