<script>
  import axios from 'axios';
  import { router as Inertia } from '@inertiajs/svelte';

  import store from '@/store';

  import { Button, Column, Context, Input, Text, CheckBox, Row } from '@/lib/structe/index.js';

  let state = $state(store.modal.params);
  let is_new = $derived(state.fields?.id === undefined);

  const onSave = async () => {
    if (is_new) {
      await axios.post('/tariffs', state.fields);
    } else {
      await axios.put(`/tariffs/${state.fields.id}`, state.fields);
    }
    Inertia.reload();
    store.modal.close();
  };

  const onClose = () => {
    store.modal.close();
  };

  const onDelete = async () => {
    await axios.delete(`/tariffs/${state.fields.id}`);
    Inertia.reload();
    store.modal.close();
  };

  const css_title = 'text-center text-lg font-bold';
  const css_form = 'sm:w-96 w-full border border-black rounded-lg p-4 bg-white';
  const css_column = 'mt-4 gap-1';
  const css_button = 'w-full border border-black hover:border-blue-600';
</script>

<Context context={state.fields}>
  <Column class={css_form}>
    <Text class={css_title}>
      {is_new ? 'Новый тариф' : `Тариф №${state.fields.id}`}
    </Text>
    <Column class={css_column}>
      <Input name="ration_name">Имя рациона</Input>
      <CheckBox name="cooking_day_before">Готовить за день</CheckBox>
    </Column>
    <Row class="mt-4 gap-4">
      <Button click={onSave} class="{css_button} bg-black text-white hover:bg-blue-600">
        Сохранить
      </Button>
      <Button click={onClose} class={css_button}>
        Закрыть
      </Button>
    </Row>
    {#if !is_new}
      <Button click={onDelete} class="{css_button} mt-2 bg-red-800 text-white hover:bg-red-600">
        Удалить
      </Button>
    {/if}
  </Column>
</Context>
