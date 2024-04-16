const btn_agregar = document.getElementById('agregar');
btn_agregar.addEventListener("click", function(){


//se declaran las variables de los 'div' a utilizar para generar los campos agregados
  const div_principal = D.create('div');

  const div_producto = D.create('div');

  const div_cantidad = D.create('div');


//se generan los campos de texto para identificar a los datos a ingresar
//también se crea los input para dar ingreso los datos requeridos
  const span_producto = D.create('span', {innerHTML:'SN. del producto:',style:"margin-left: 7px;" });
  const input_producto = D.create('input',{type:'text', name:'producto[]', id:"prod",
  autocomplete:'off', placeholder:'Ingrese sn'});
  
  const span_cantidad = D.create('span', {innerHTML:'Cantidad de prod:',style:"margin-left: 7px;" });
  const input_cantidad = D.create('input',{type:'text', name:'cantidad[]', id:"cant",
  autocomplete:'off', placeholder:'Ingrese unidad'});

//se crea un boton de eliminar el div
  const borrar = D.create('a', {href: 'javascript:void(0)', innerHTML:
  'x', id:"borrar", onclick:function(){D.remove(div_principal); } });

  
//agrega cada equiteta a su nodo padre
  D.append(span_producto,div_producto);
  D.append(input_producto, div_producto);

  D.append([span_cantidad, input_cantidad],div_cantidad);
  D.append([div_producto, div_cantidad, borrar ], div_principal);
  
  D.append(div_principal, D.id('container') );

  // console.log(div_producto);
  
});