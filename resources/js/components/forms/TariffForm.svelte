<script>
  import store from "@/store";
  import { Button, Column, Context, Input, Text, CheckBox, Row } from '@/lib/structe/index.js';
  import { router as Inertia } from '@inertiajs/svelte';
  import axios from 'axios';

  let fields = $state(store.modal.params);
  let is_new = $derived(fields.id === undefined);

  const onSave = async() => {
    if (is_new) {
      await axios.post('/tariffs', fields);
    } else {
      await axios.put(`/tariffs/${fields.id}`, fields);
    }
    Inertia.reload({ only: ['tariffs'] });
    store.modal.close();
  };

  const onClose = () => {
    store.modal.close();
  };

  const onDelete = async() => {
    await axios.delete(`/tariffs/${fields.id}`);
    Inertia.reload({ only: ['tariffs'] });
    store.modal.close();
  };

  const css_title = "text-center text-lg font-bold"
  const css_form = "sm:w-96 w-full border border-black rounded-lg p-4 bg-white";
  const css_column = "mt-4 gap-1";
  const css_button = "w-full border border-black";
</script>

<Context context={fields}>
  <Column class={css_form}>
    <Text class={css_title}>
      {is_new? 'Новый тариф': `Тариф ${fields.id}`}
    </Text>
    <Column class={css_column}>
      <Input name="ration_name">Имя рациона</Input>
      <CheckBox name="cooking_day_before">Готовить за день</CheckBox>
    </Column>
    <Row class="mt-4 gap-4">
      <Button click={onSave} class="{css_button} bg-black text-white">
        Сохранить
      </Button>
      <Button click={onClose} class={css_button}>
        Закрыть
      </Button>
    </Row>
    {#if !is_new}
      <Button click={onDelete} class="{css_button} mt-2 bg-red-800 text-white">
        Удалить
      </Button>
    {/if}
  </Column>
</Context>
