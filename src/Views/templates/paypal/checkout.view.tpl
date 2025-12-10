<section style="
    max-width: 600px;
    margin: 40px auto;
    padding: 24px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    text-align: center;
    font-family: 'Arial', sans-serif;
">
  
  <h2 style="margin-bottom: 20px; font-size: 1.6rem; font-weight: bold;">
    ¿Estás seguro que deseas realizar el pedido?
  </h2>

  <form action="index.php?page=checkout_checkout" method="post" style="margin-bottom: 18px;">
    <button type="submit" style="
        width: 100%;
        padding: 14px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s ease;
    ">
      Sí
    </button>
  </form>

  <form action="index.php?page=Products-Catalogo" method="post">
    <button type="submit" style="
        width: 100%;
        padding: 14px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s ease;
    ">
      No
    </button>
  </form>

</section>
