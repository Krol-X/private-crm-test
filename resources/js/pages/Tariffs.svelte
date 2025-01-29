<script>
  import axios from 'axios';

  import { Button, Column, Context, Input, Row } from '@/lib/structe/index.js';
  import CheckBox from '@/lib/structe/atoms/form/CheckBox.svelte';
  import { router as Inertia } from '@inertiajs/svelte';

  let { tariffs } = $props();

  async function addTariff(e, context) {
    try {
      await axios.post('/tariffs', context);
      Inertia.reload({ only: ['tariffs'] });
    } catch (error) {
      console.log(error);
    }
  }

  async function removeTariff(id) {
    await axios.delete(`/tariffs/${id}`);
    Inertia.reload({ only: ['tariffs'] });
  }
</script>

<Context>
  <Column>
    <Input name="ration_name">Имя рациона</Input>
    <CheckBox name="cooking_day_before">Готовить за день</CheckBox>
    <Button click={addTariff}>Добавить</Button>
  </Column>
</Context>

<Column class="tariffs">
  {#each tariffs as tariff(tariff.id)}
    <Column class="border border-black p-1">
      <Row class="w-full justify-between">
        <div>Id</div>
        <div>{tariff.id}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Имя рациона</div>
        <div>{tariff.ration_name}</div>
      </Row>
      <Row class="w-full justify-between">
        <div>Готовить за день</div>
        <div>{tariff.cooking_day_before? 'Да': 'Нет'}</div>
      </Row>
      <Button click={() => removeTariff(tariff.id)}>Удалить</Button>
    </Column>
  {/each}
</Column>

<style>
  :global(.tariffs) {
    margin-top: 1rem;
    max-width: 32rem;
    margin-left: auto;
    margin-right: auto;

    gap: 1rem;
  }
</style>
