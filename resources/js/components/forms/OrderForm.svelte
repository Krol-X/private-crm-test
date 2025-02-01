<script>
  import store from '@/store';
  import { Button, Column, Context, Input, Text, Row, Select } from '@/lib/structe';
  import { router as Inertia } from '@inertiajs/svelte';
  import axios from 'axios';
  import RationsForm from './RationsForm.svelte';

  let state = $state(store.modal.params);
  const order_id = $derived(state.fields?.id);
  let is_new = $derived(order_id === undefined);

  let tariffOptions = $derived(
    state?.tariffs?.data.map(
      function(tariff) {
        return {
          value: tariff.id,
          label: tariff.ration_name
        };
      })
  );

  const scheduleOptions = [
    { value: 'EVERY_DAY', label: 'Каждый день' },
    { value: 'EVERY_OTHER_DAY', label: 'Через день' },
    { value: 'EVERY_OTHER_DAY_TWICE', label: 'Через день дважды' }
  ];

  const onSave = async () => {
    if (is_new) {
      await axios.post('/orders', state.fields);
    } else {
      // await axios.put(`/orders/${state.fields.id}`, state.fields);
    }
    Inertia.reload();
    store.modal.close();
  };

  const onClose = () => {
    store.modal.close();
  };

  const openRations = () => {
    store.modal.open(RationsForm);
  };

  const css_title = 'text-center text-lg font-bold';
  const css_form = 'sm:w-96 w-full border border-black rounded-lg p-4 bg-white';
  const css_column = 'mt-4 gap-1';
  const css_button = 'w-full border border-black';
</script>

<Context context={state.fields}>
  <Column class={css_form}>
    <Text class={css_title}>
      {is_new ? 'Новый заказ' : `Заказ №${order_id}`}
    </Text>

    <Column class={css_column}>
      <Input name="client_name">ФИО клиента</Input>

      <Input name="client_phone" type="tel" pattern="[0-9]{11}"
             max=11
      >
        Телефон (11 цифр)
      </Input>

      {#if is_new}
        <Select name="tariff_id" options={tariffOptions} >
          Тариф
        </Select>
      {:else}
        <Input value={state.fields?.tariff.ration_name}>
          Тариф
        </Input>
      {/if}

      <Select name="schedule_type" options={scheduleOptions}>
        Тип расписания
      </Select>

      <Input name="comment" multiline>Комментарий</Input>

      <Input name="first_date" type="date">
        Дата начала доставки
      </Input>

      <Input name="last_date" type="date">
        Дата окончания доставки
      </Input>
    </Column>

    {#if is_new}
      <Row class="mt-4 gap-4">
        <Button click={onSave} class="{css_button} bg-black text-white">
          Сохранить
        </Button>
        <Button click={onClose} class={css_button}>
          Закрыть
        </Button>
      </Row>
    {:else}
      <Column class="mt-4 gap-1">
        <Button click={openRations} class="{css_button} bg-black text-white">
          Рационы
        </Button>
        <Button click={onClose} class={css_button}>
          Закрыть
        </Button>
      </Column>
    {/if}
  </Column>
</Context>
