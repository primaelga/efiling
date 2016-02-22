
Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.selection.CheckboxModel'

]);
	
var getLocalStore1;
Ext.define('My.sample.Person', {
    name: 'Unknown',

    constructor: function(name) {
        if (name) {
            this.name = name;
        }
    },
	
    eat: function(foodType) {
        //alert(this.name + " is eating: " + foodType);
		
	   Ext.define('customer_po_number', {
			extend: 'Ext.data.Model',
			fields: [
				{name: 'customer_po_number',type :'string'},
				{name: 'po_for',			type :'string'},
				{name: 'project_id',		type :'string'},
				{name: 'actual_price',		type :'string'},
				{name: 'bast_value',		type :'string'},
				{name: 'currency',			type :'string'},
				{name: 'receipt_number',	type :'string'},
				{name: 'invoice_number',	type :'string'},
				{name: 'tax_form_number',	type :'string'}
			 ]
		}),
		
		getLocalStore1 = Ext.create('Ext.data.Store', {
			storeId:'getLocalStore',
			model: 'customer_po_number',
			remoteGroup: true,
			leadingBufferZone: 300,
			proxy:	{
				type: 'ajax',
				url: 'loadponumber.php',
				reader:{
					type:'json'
				}
			}
		})
		getLocalStore1.load({params:{sitehandler:'100001'}});		
    }
	
	
});