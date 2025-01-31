import * as yup from 'yup';
import { RestApi } from '@/lib/rest_api.js';

export const rationsYupRules = {
  respList: yup.array(
    yup.object({
      id: yup.number().required(),
      order_id: yup.number().required(),
      cooking_date: yup.date().required(),
      cooking_day_before: yup.bool().required(),
      delivery_date: yup.date().required()
    })
  )
};

export const rationsRestApi = new RestApi({
  list: {
    method: 'get',
    path: 'rations',
    serializer: async (order_id) => {
      if (order_id !== undefined) {
        return [{ order_id }];
      } else {
        return [];
      }
    },
    deserializer: async (response) => {
      const resp = await rationsYupRules.respList.validate(response.data);

      return resp;
    }
  }
});
