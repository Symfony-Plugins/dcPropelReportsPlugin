function dc_propel_table_update_alias()
{
  if ($('dc_report_table_has_alias')!=null)
  {
    $('dc_report_table_has_alias').checked?$('dc_report_table_alias').enable():$('dc_report_table_alias').disable();
  }
}


Event.observe(window,'load',dc_propel_table_update_alias);

function dc_propel_relation_update_columns_JSON(ajax,element)
{
  json = ajax.responseJSON;
  element.options.length=0;
  json.each(function (option){
    element.options.add(new Option(option.id,option.value));  
  });
}
