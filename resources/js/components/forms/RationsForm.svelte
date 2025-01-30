<script>
  import store from '@/store';
  import { Button, Column, Context, Text, Row } from '@/lib/structe/index.js';
  import OrderForm from './OrderForm.svelte';
  import { onMount } from 'svelte';

  let state = $state(store.modal.params);
  const order_id = $derived(state.fields.id);

  const onClose = () => {
    store.modal.open(OrderForm);
  };

  const css_title = 'text-center text-lg font-bold';
  const css_form = 'sm:w-96 w-full max-h-screen border border-black rounded-lg p-4 bg-white';
  const css_column = 'mt-4 gap-2 overflow-y-auto';
  const css_button = 'w-full border border-black';

  let rations = $state([
    {
      'id': 26,
      'order_id': 17,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 27,
      'order_id': 17,
      'cooking_date': '2025-01-03 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-03 00:00:00'
    },
    {
      'id': 28,
      'order_id': 17,
      'cooking_date': '2025-01-05 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-05 00:00:00'
    },
    {
      'id': 29,
      'order_id': 18,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 30,
      'order_id': 18,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 31,
      'order_id': 18,
      'cooking_date': '2025-01-02 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-02 00:00:00'
    },
    {
      'id': 32,
      'order_id': 18,
      'cooking_date': '2025-01-02 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-02 00:00:00'
    },
    {
      'id': 33,
      'order_id': 18,
      'cooking_date': '2025-01-03 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-03 00:00:00'
    },
    {
      'id': 34,
      'order_id': 18,
      'cooking_date': '2025-01-03 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-03 00:00:00'
    },
    {
      'id': 35,
      'order_id': 18,
      'cooking_date': '2025-01-04 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-04 00:00:00'
    },
    {
      'id': 36,
      'order_id': 18,
      'cooking_date': '2025-01-04 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-04 00:00:00'
    },
    {
      'id': 37,
      'order_id': 18,
      'cooking_date': '2025-01-05 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-05 00:00:00'
    },
    {
      'id': 38,
      'order_id': 19,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 39,
      'order_id': 19,
      'cooking_date': '2025-01-02 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-02 00:00:00'
    },
    {
      'id': 40,
      'order_id': 19,
      'cooking_date': '2025-01-05 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-05 00:00:00'
    },
    {
      'id': 41,
      'order_id': 20,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 42,
      'order_id': 21,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 43,
      'order_id': 21,
      'cooking_date': '2025-01-01 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-01 00:00:00'
    },
    {
      'id': 44,
      'order_id': 21,
      'cooking_date': '2025-01-03 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-03 00:00:00'
    },
    {
      'id': 45,
      'order_id': 21,
      'cooking_date': '2025-01-03 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-03 00:00:00'
    },
    {
      'id': 46,
      'order_id': 21,
      'cooking_date': '2025-01-05 00:00:00',
      'cooking_day_before': 0,
      'delivery_date': '2025-01-05 00:00:00'
    }
  ]);

  onMount(async () => {
    // rations = вызов api через store
  });
</script>

<Context context={state.fields}>
  <Column class={css_form}>
    <Text class={css_title}>
      Рационы для заказа №{order_id}
    </Text>
    <Column class={css_column}>
      {#each rations as ration(ration.id)}
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
    </Column>
    <Row class="mt-4 gap-4">
      <Button click={onClose} class={css_button}>
        Закрыть
      </Button>
    </Row>
  </Column>
</Context>
