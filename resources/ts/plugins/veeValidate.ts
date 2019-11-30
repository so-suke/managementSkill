import { extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import * as ja from "vee-validate/dist/locale/ja";
import { EmailModule } from "@modules/email";

for (let rule in rules) {
  extend(rule, {
    ...(rules as any)[rule],
    message: ja.messages[rule]
  });
}

extend("uniqEmail", {
  validate: async (email: string) => {
    const params = new URLSearchParams();
    params.append("email", email);

    return window.axios.post(`/api/isUniqEmail`, params)
      .then(response => {
        return !response.data.exists;
      })
      .catch(error => {
        console.warn(error);
        return true;
      });
  },
  message: "対象のメールアドレスは、既に存在しています。"
});
