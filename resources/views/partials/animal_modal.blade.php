<!-- partials/animal_modal.blade.php -->
<style>
/* MODAL */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
}

.modal-content {
    background: white;
    margin: 5% auto;
    padding: 25px;
    width: 90%;
    max-width: 400px;
    border-radius: 15px;
    text-align: center;
    animation: fadeIn 0.3s ease;
}

.modal-content img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.close {
    float: right;
    font-size: 28px;
    cursor: pointer;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>

<!-- MODAL -->
<div id="animalModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>

        <img id="modalImg" src="" alt="">

        <h2 id="modalNombre"></h2>
        <p><strong>Edad:</strong> <span id="modalEdad"></span></p>
        <p><strong>Raza:</strong> <span id="modalRaza"></span></p>
        <p id="modalHistoria"></p>
    </div>
</div>

<script>
    function abrirModal(nombre, edad, raza, historia, foto) {
        document.getElementById('modalNombre').innerText = nombre;
        document.getElementById('modalEdad').innerText = edad;
        document.getElementById('modalRaza').innerText = raza;
        document.getElementById('modalHistoria').innerText = historia;
        document.getElementById('modalImg').src = foto;

        document.getElementById('animalModal').style.display = 'block';
    }

    function cerrarModal() {
        document.getElementById('animalModal').style.display = 'none';
    }

    /* cerrar al hacer click afuera */
    window.onclick = function(e) {
        const modal = document.getElementById('animalModal');
        if (e.target === modal) {
            modal.style.display = "none";
        }
    }
</script>
