function convertFormDataToObject(data) {
    let resultInObj = {};
    data?.forEach(function(item) {
        resultInObj[item?.name] =  item?.value ;
    });
    return resultInObj;

}