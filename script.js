  let cart={};
    const prices={"Salted Caramel":25000,
      "Coffee 5cm":15000,
      "Matcha Latte":28000,
       "5cm Lasagna":35000,
       "Aglio O Elio":30000,
       "Nasi Goreng Kampung":22000
      };

  function scrollToMenu(element){
    element.scrollIntoView({behavior:'smooth'});
  }
  function scrollToTop(){window.scrollTo({top:0,behavior:'smooth'});}


  function addToCart(item){
    if(!cart[item]) cart[item]=1; else cart[item]++;
    updateCart();
  }

  function decreaseItem(item){
    if(cart[item]){
      cart[item]--;
      if(cart[item]<=0) delete cart[item];
    }
    updateCart();
  }

  function updateCart(){
    let total=0, harga=0;
    for(let item in cart)
      {total+=cart[item];
      harga+=cart[item]*prices[item];
      }
    document.getElementById('cartCount').innerText=total;
    document.getElementById('totalHarga').innerText='Total: Rp '+harga.toLocaleString();
  }

  function showCart(){
    let text='Halo 5CM Cafe,%0A Saya ingin pesan:%0A';
    let totalHarga=0;
    for(let item in cart){
      text+=item+' x'+cart[item]+'%0A';
      totalHarga+=cart[item]*prices[item];
    }
    text+='%0ATotal: Rp '+totalHarga.toLocaleString();
    window.open('https://wa.me/628950891543?text='+text);
  }


  // Back to top button visibility
  window.addEventListener('scroll',()=>{
    const btn=document.getElementById('backTop');
    if(window.scrollY>300) btn.style.display='block'; else btn.style.display='none';
  });