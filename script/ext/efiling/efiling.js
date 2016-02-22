Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.selection.CheckboxModel'

]);

var tech;
var sh_id;
var win;
Ext.onReady(function () {
	
	Ext.define('sitehandler_id', {
		extend: 'Ext.data.Model',
		fields: [			
			{name: 'name', 						type: 'string'},
			{name: 'sitehandler_id', 			type: 'string'},
			{name: 'site_id', 					type: 'string'},
			{name: 'site_name', 				type: 'string'},
			{name: 'far_end_site_id', 			type: 'string'},
			{name: 'far_end_site_name', 		type: 'string'},
			{name: 'site_id_actual', 			type: 'string'},
			{name: 'site_name_actual', 			type: 'string'},			
			{name: 'far_end_site_id_actual', 	type: 'string'},
			{name: 'far_end_site_name_actual', 	type: 'string'},
			{name: 'region_name', 				type: 'string'},
			{name: 'on_air_date', 				type: 'string'},
			{name: 'trigger_capitalization', 	type: 'string'},
			{name: 'scope', 					type: 'string'},
			{name: 'reference_number', 			type: 'string'}
		]
	});

	var getLocalStore =  Ext.create('Ext.data.Store', {
		model: 'sitehandler_id',
		pageSize : 25,
		remoteSort: true,
		proxy:	{
			type: 'jsonp',
			url: 'loadData.php',
			reader:{
				root: 'root',
				totalProperty: 'total'
			},
			simpleSortMode: true
		}
	});

    var html2 = '<div><script src="http://localhost:8080/html/js/liferay/widget.js" type="text/javascript"></script> \
				<script type="text/javascript"> \
				Liferay.Widget({ url: "http://www.google.co.id"}); \
				</script></div>';	



				
	Ext.create('Ext.panel.Panel', {    
		height: 300,
		title: "Search Filter",
		layout: {
			type: 'hbox',
			align: 'stretch'
		},    
		items: [{
			xtype: 'panel',			
			bodyPadding: '10px 0 0 100px',
			items:[
				{xtype: 'textfield', width: 500, id: 'company', 		name: 'company', 		fieldLabel: 'Company',        	labelWidth: 200, emptyText : 'Company', 		fieldStyle: 'background-color: #33ccff;'},
				{xtype: 'textfield', width: 500, id: 'purchase',		name: 'purchase',		fieldLabel: 'Purchase Order', 	labelWidth: 200, emptyText : 'Purchase Order', 	fieldStyle: 'background-color: #33ccff;'},
				{xtype: 'textfield', width: 500, id: 'siteid',  		name: 'siteid',  		fieldLabel: 'Site Id',        	labelWidth: 200, emptyText : 'Site Id', 		fieldStyle: 'background-color: #33ccff;'},
				{xtype: 'textfield', width: 500, id: 'sitename',		name: 'sitename',		fieldLabel: 'Site Name', 		labelWidth: 200, emptyText : 'Site Name', 		fieldStyle: 'background-color: #33ccff;'},
				{xtype: 'textfield', width: 500, id: 'siteidactual', 	name: 'siteidactual', 	fieldLabel: 'Site Id Actual', 	labelWidth: 200, emptyText : 'Site Id Actual' },
				{xtype: 'textfield', width: 500, id: 'sitenameactual',	name: 'sitenameactual',	fieldLabel: 'Site Name Actual', labelWidth: 200, emptyText : 'Site Name Actual'},
				{xtype: 'textfield', width: 500, id: 'invoicenumber', 	name: 'invoicenumber', 	fieldLabel: 'Invoice Number', 	labelWidth: 200, emptyText : 'Invoice Number'}
			]			
		},{
			xtype: 'panel',			
			bodyPadding: '10px 0 0 120px',
			items:[
				{xtype: 'textfield', width: 500, id: 'procestechnology', 	name: 'procestechnology', 	fieldLabel: 'Proces Technology', 	labelWidth: 200, emptyText :'Proces Technology'},
				//{xtype: 'textfield', width: 500, id: 'milestone', 			name: 'milestone', 			fieldLabel: 'Milestone', 			labelWidth: 200, emptyText :'Milestone'},
				Ext.create('Ext.form.ComboBox',{
					emptyText 		:'Milestone',
					fieldLabel		: 'Milestone',
					labelWidth		: 200,
					width			: 500,
					editable		: false,
                    displayField	: 'name',
                    valueField		: 'value',
					store: Ext.create('Ext.data.Store', {
						fields: ['value', 'name'],
                        data : [
							{ value: 'all', 	name: 'ALL' },
							{ value: 'e-baut', 	name: 'e-BAUT' },
							{ value: 'e-soac', 	name: 'e-SOAC' },
							{ value: 'e-gac', 	name: 'e-GAC' },
							{ value: 'e-atp', 	name: 'e-ATP' },
							{ value: 'e-bast', 	name: 'e-BAST' }
						]
					})
				}),
				{xtype: 'textfield', width: 500, id: 'documentname', 		name: 'documentname', 		fieldLabel: 'Document Name', 		labelWidth: 200, emptyText :'Document Name'},
				//{xtype: 'textfield', width: 500, id: 'donerange', 			name: 'donerange', 			fieldLabel: 'Done Range', 			labelWidth: 200, emptyText :'Done Range'},
				{
					layout: 'hbox',
					padding:'0 0 5 0',
					items:[
						Ext.create('Ext.form.DateField',{	
							fieldLabel	: 'Done Range',
							labelWidth	: 200,
							name		: 'donerangefrom',					
							emptyText 	: 'From',
							format		: 'd/m/Y',
							width		: 350
						}),
						Ext.create('Ext.form.DateField',{	
							fieldLabel	: '&nbsp',
							labelWidth	: 10,
							name		: 'donerangeto',					
							emptyText 	: 'To',
							format		: 'd/m/Y',
							width		: 150
						}),
					]
				},				
				{xtype: 'textfield', width: 500, id: 'projectid', 			name: 'projectid', 			fieldLabel: 'Project Id', 			labelWidth: 200, emptyText :'Project Id', 	fieldStyle: 'background-color: #33ccff;'},
				{
					layout: 'hbox',
					padding:'0 0 5 0',
					items:[
						Ext.create('Ext.form.DateField',{	
							fieldLabel	: 'On Air Date',
							labelWidth	: 200,
							name		: 'tglfrom',					
							emptyText 	: 'From',
							format		: 'd/m/Y',
							width		: 350
						}),
						Ext.create('Ext.form.DateField',{	
							fieldLabel	: '&nbsp',
							labelWidth	: 10,
							name		: 'tglto',					
							emptyText 	: 'To',
							format		: 'd/m/Y',
							width		: 150
						}),
					]
				},
				{xtype: 'textfield', width: 500, name: 'taxform', fieldLabel: 'Tax Form Number', labelWidth: 200, emptyText :'Tax Form Number'}
			]
		}],
		buttons: [
			{ 
				text: 'Search',
				style:'background-color:#d1111a',
				handler:function(){
					
					var cmp 		= Ext.getCmp('company').getValue();
					var po_number	= Ext.getCmp('purchase').getValue();
					var sid 		= Ext.getCmp('siteid').getValue();
					var sname		= Ext.getCmp('sitename').getValue();					
					var projid		= Ext.getCmp('projectid').getValue();
					var invnumber 	= Ext.getCmp('invoicenumber').getValue();
					
					getLocalStore.load({params:{
							act:3,company:cmp, customerponumber:po_number, siteid:sid, sitename:sname, 
							projectid:projid, invoicenumber:invnumber
							},
						callback:function(records, operation, success)
						{
							if(success == true)
							{
								if(records.length == 0)
								{
									Ext.Msg.alert('Result','Data not found');
								}
							}							
							if(success == false)
							{
								try{
									Ext.Msg.alert('Error', operation.getError());
								}catch(e){
									Ext.Msg.alert('Error', 'Server Error');
								}
							}
						}
					});
				}
			},
			{ 
				text: 'Reset',
				handler:function()
				{
					/*
					Ext.getCmp('company').setValue('');
					Ext.getCmp('purchase').setValue('');
					Ext.getCmp('siteid').setValue('');
					Ext.getCmp('sitename').setValue('');
					Ext.getCmp('projectid').setValue('');
					Ext.getCmp('invoicenumber').setValue('');
					getLocalStore.load({params:{start:1, limit:25}})
					*/
				}
			}
		],
		renderTo: 'panel',
		margin: '0 0 20 0'
	});
	
    var grid1 = Ext.create('Ext.grid.Panel', {
		title: 'Document List',
		store: getLocalStore,		
		columns: [
			//{text: 'SITE HANDLER',				width: 0, sortable: false,dataIndex:'sitehandler_id'},
			{text: 'COMPANY',	 				width: 100, sortable: false,dataIndex:'name'},
			{text: 'SITE ID',	 				width: 100, sortable: false,dataIndex:'site_id'},
			{text: 'SITE NAME', 				width: 100, sortable: false,dataIndex:'site_name'},
			{text: 'FAR END SITE_ID', 			width: 100, sortable: false,dataIndex:'far_end_site_id'},		
			{text: 'FAR END SITE_NAME', 		width: 100, sortable: false,dataIndex:'far_end_site_name'},
			{text: 'SITE ID ACTUAL', 			width: 100, sortable: false,dataIndex:'site_id_actual'},
			{text: 'TECHNOLOGY', 			 	width: 100, sortable: false,dataIndex:'technology'},			
			{text: 'SITE NAME ACTUAL', 			width: 100, sortable: false,dataIndex:'site_name_actual'},		
			{text: 'FAR END SITE ID_ACTUAL', 	width: 100, sortable: false,dataIndex:'far_end_site_id_actual'},
			{text: 'FAR END SITE NAME ACTUAL', 	width: 100, sortable: false,dataIndex:'far_end_site_name_actual'}, 	
			{text: 'REGION', 					width: 100, sortable: false,dataIndex:'region_name'},
			{text: 'ON AIR DATE', 				width: 100, sortable: false,dataIndex:'on_air_date'},
			{text: 'TRIGGER CAPITALIZATION', 	width: 100, sortable: false,dataIndex:'trigger_capitalization'},
			{text: 'SCOPE', 					width: 100, sortable: false,dataIndex:'scope'},
			{text: 'REFERENCE NUMBER', 			width: 100, sortable: false,dataIndex: 'reference_number'}			
		],
		listeners:{
			select: function(selModel, record, index, options)
			{
				sh_id = record.get('sitehandler_id');
				tech = record.get('technology');
				getPOStore.load({params:{sitehandler:sh_id}});
				getDocStore.load({params:{sitehandler:sh_id}});
			}
		},
		bbar : Ext.create('Ext.PagingToolbar',{			
			store: getLocalStore,
			displayInfo: true,
			displayMsg: '{0} - {1} of {2}',
			emptyMsg: "No topics to display"			
		}),
		sortableColumns : false,		
        columnLines: true,
        height: 340,		
		flex:1,
		
        margin: '0 0 20 0'        
    });


//=========================================PO NUMBER======================================
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
			{name: 'tax_form_number',	type :'string'},
			{name: 'approval_status',	type :'string'}
			
         ]
    });
	
	
    var getPOStore = Ext.create('Ext.data.Store', {
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
	});	
	
	var gridPO = Ext.create('Ext.grid.Panel',{
		id: 'getPOStore',
		store: getPOStore,								
		columns: [
			{text: "PO Number", 		 width: 120, align:'center', sortable: false,dataIndex: 'customer_po_number'},
			//{text: "PO For", 			 width: 120, align:'center', sortable: false,dataIndex: 'po_for'},
			{text: "Project Id", 		 width: 150, align:'center', sortable: false,dataIndex: 'project_id'},
			{text: "Actual Price", 		 width: 120, align:'center', sortable: false,dataIndex: 'actual_price'},
			{text: "Contract Price", 	 width: 120, align:'center', sortable: false,dataIndex: 'contract_price'},
			{text: "Bast Value", 		 width: 120, align:'center', sortable: false,dataIndex: 'bast_value'},
			{text: "Currency", 			 width: 80,  align:'center', sortable:  false,dataIndex: 'currency'},
			{text: "Receipt Number", 	 width: 140, align:'center', sortable: false,dataIndex: 'receipt_number'},
			{text: "Invoice Number", 	 width: 160, align:'center', sortable: false,dataIndex: 'invoice_number'},
			{text: "Tax Form Number", 	 width: 160, align:'center', sortable: false,dataIndex: 'tax_form_number'},
			{text: "Approval Status", 	 width: 120, align:'center', sortable: false,dataIndex: 'tax_form_number'},
		],
		columnLines: true,
		height: 150
	});


//=========================================DOCUMENT=================================================


    Ext.define('document', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'name',		type :'string'},
            {name: 'file_name',	type :'string'},
			{name: 'path_file', type :'string'},
            {name: 'doc_date',	type :'string'},
			{name: 'doctype',	type :'string'}
			
         ]
    });

    var getDocStore = Ext.create('Ext.data.Store', {
		storeId:'getDocumentStore',
		model: 'document',
		remoteGroup: true,
        leadingBufferZone: 300,
		groupField: 'name',
		proxy:	{
			type: 'ajax',
			url: 'loaddocument.php',
			reader:{
				type:'json'
			}
		}
	});	
	
	var groupingFeature = Ext.create('Ext.grid.feature.Grouping',{		
        //groupHeaderTpl: '{name} ({rows.length} Item{[values.rows.length > 2 ? "s" : ""]})'
		groupHeaderTpl: '{name}'
    });
	
	
	var fl = false;
	var gridDocument = Ext.create('Ext.grid.Panel',{
		id: 'LocalStore_',
		store: getDocStore,
		features: [groupingFeature],
		columns: [
			{text: "Milestone", 		width: 160,	align:'center', dataIndex: 'name'},			
			{text: "Document Name",  	width: 650, dataIndex: 'file_name'},
			{text: "Document Date",  	width: 160,	align:'center', dataIndex: 'doc_date'},
			{text: "Document Type",  	width: 120,	align:'center', dataIndex: 'doctype'},
			{
				xtype : 'actioncolumn',
				header : 'View Document',
				width : 120,
				align : 'center',
				items : [{
					icon:'../images/download-bottom.png',
					tooltip : 'View Document',
					handler : function (grid, rowIndex, colIndex, item, e, record) {
						var fn = record.get('file_name');
						var fname = "";
						fname = fn.replace(" ","%20");
						fname = fname.replace("+", "%2B");
						
						var tfile =  fname.split('_');
						var pfile = record.get('path_file')+'e-'+tfile[0]+'/';

						var win = new Ext.Window({
							height:800, width:800,
							x:250,
							y:400,
							id:'win',							
							items:{
								xtype:'component',
								autoEl:{
									tag:'iframe',
									style: 'height: 100%; width: 100%; border: none',
									src:'../document'+pfile+fname
								}
							},
							buttons: [{
								text: 'Close',
								handler: function() 
								{
									fl = false;
									win.destroy();
								}
							}]
						});
						
						win.on('beforeshow', function(){							
							fl = true;
						});
						win.on('beforeclose', function(){
							fl = false;
							win.destroy();
						});
						
						if(fl == false)
						{
							win.show();	
						}

						/*
						Ext.getBody().mask('Loading....', 'x-mask-loading');
						Ext.getBody().createChild({
							tag: 'iframe',
							cls: 'x-hidden',
							onload: 'Ext.getBody().unmask(); var t = Ext.get(this);',// t.remove.defer(1000, t);',
							src: 'downloadFile.php?pathFile='+ pfile +'&fileName='+fname
						})	
						*/
					}										
				}]
			}
		],
		columnLines: true,
		height: 150
	});
	
	

	Ext.create('Ext.Panel', {        
        frame: true,        
        height: 600,        
		renderTo: Ext.getBody(),
        items: [grid1,{
			id: 'detailPanel',
                region: 'center',
                bodyPadding: 7,
                //bodyStyle: "background: #ffffff;",
                //html: 'Please select a book to see additional details.'
				items:[Ext.create('Ext.tab.Panel',{
					items:[
						{
							title:'PO NUMBER',
							items:[Ext.create('Ext.Panel',{
								id: 'detailPanel1',
								height: 150,
								items:[gridPO]
								
							})]
						},
						{
							title:'DOCUMENT',
							items:[Ext.create('Ext.Panel',{
								id: 'detailPanel2',
								height: 150,
								items:[gridDocument]
							})]
					}]
				})]
		}]
	});	
	getLocalStore.load({params:{start:1, limit:25}});
});