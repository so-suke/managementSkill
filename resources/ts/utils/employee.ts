export const getEmployee = (id: string) => {
  window.axios.get(`/api/employees/${id}`).then(res => {
    return res.data;
  });
}
