const isValidNumber = function (str = "") {
  const reg = /^[0-9]+\.?[0-9]*?$/;
  if (isNaN(str)) {
    return false;
  }
  if (str.match(reg)) {
    return false;
  }
  return parseFloat(str);
};
const stringToMoney = (str = "") => {
  const money = new Intl.NumberFormat("de-DE", {
    style: "currency",
    currency: "VND",
  }).format(str);
  return money;
};
