{{--Чтобы заюзать прелоадер div с контентом должен иметь класс page и иметь inline--}}
{{--стиль display: none--}}


<div id="preloader"
     class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white"
     style="z-index: 1050;">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        document.getElementById('preloader').remove();  // Удаляем прелоадер
        document.querySelector('.page').style.display = 'block';  // Показываем контент
    });
</script>
