<script>
  import { onMount } from 'svelte';

  import store from '@/store';

  import OrderForm from './OrderForm.svelte';
  import { Button, Column, Context, Text, Row } from '@/lib/structe';

  let state = $state(store.modal.params);
  const order_id = $derived(state.fields.id);

  const onClose = () => {
    store.modal.open(OrderForm);
  };

  const css_title = 'text-center text-lg font-bold';
  const css_form = 'sm:w-96 w-full max-h-screen border border-black rounded-lg p-4 bg-white';
  const css_column = 'mt-4 gap-2 overflow-y-auto';
  const css_button = 'w-full border border-black';

  onMount(async () => {
    await store.rations.fetch(order_id);
  });
</script>

<Context context={state.fields}>
  <Column class={css_form}>
    <Text class={css_title}>
      Рационы для заказа №{order_id}
    </Text>
    <Column class={css_column}>
      {#if store.rations.is_loading}
        Загрузка...
      {:else}
        {#each store.rations.list as ration(ration.id)}
          <Column class="border-2 border-black hover:border-blue-600 p-2 rounded-lg">
            <Row class="w-full justify-between">
              <div>ID рациона</div>
              <div>{ration.id}</div>
            </Row>
            <hr class="border-inherit" />
            <Row class="w-full justify-between">
              <div>ID заказа</div>
              <div>{ration.order_id}</div>
            </Row>
            <Row class="w-full justify-between">
              <div>Дата готовки</div>
              <div>
                {new Date(ration.cooking_date).toLocaleDateString()}
              </div>
            </Row>
            <Row class="w-full justify-between">
              <div>Готовилось за день</div>
              <div>{ration.cooking_day_before ? 'Да' : 'Нет'}</div>
            </Row>
            <Row class="w-full justify-between">
              <div>Дата доставки</div>
              <div>
                {new Date(ration.delivery_date).toLocaleDateString()}
              </div>
            </Row>
          </Column>
        {/each}
      {/if}
    </Column>
    <Row class="mt-4 gap-4">
      <Button click={onClose} class={css_button}>
        Закрыть
      </Button>
    </Row>
  </Column>
</Context>
