export const SCHEDULE = {
  EVERY_DAY: 'Каждый день',
  EVERY_OTHER_DAY: 'Через день',
  EVERY_OTHER_DAY_TWICE: 'Через день дважды'
};

export const SCHEDULE_OPTIONS = Object.entries(SCHEDULE).map((arr) => {
  return { value: arr[0], label: arr[1] };
});
