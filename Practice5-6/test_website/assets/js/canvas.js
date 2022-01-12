function canvas(selector, options) {
    const canvas = document.querySelector(selector);
    canvas.classList.add('canvas')
    canvas.setAttribute('width', `${options.width || 400}px`)
    canvas.setAttribute('height', `${options.height || 300}px`)


    // отримання контексту для малювання
    const context = canvas.getContext('2d')
    // отримуємо координати canvas відносно viewport
    const rect = canvas.getBoundingClientRect();
    let isPaint = false // чи активно малювання
    let points = [] //масив з точками

    // об’являємо функцію додавання точок в масив
    const addPoint = (x, y, dragging) => {
        // преобразуємо координати події кліка миші відносно canvas
        points.push({
            x: (x - rect.left),
            y: (y - rect.top),
            color: options.strokeColor,
            width: options.strokeWidth,
            dragging: dragging
        })
    }

    const img = new Image;
    img.src =`assets/img/bg.jpg`;
    img.onload = () => {
        context.drawImage(img, 0, 0);
    }
    context.drawImage(img, 0, 0);
    
    const redraw = () => {
        //очищуємо  canvas

        context.lineJoin = "round";
        context.lineWidth = options.strokeWidth;
        let prevPoint = null;
        for (let point of points){
            context.strokeStyle = point.color;
            context.beginPath();
            if (point.dragging && prevPoint){
                context.moveTo(prevPoint.x, prevPoint.y)
            } else {
                context.moveTo(point.x - 1, point.y);
            }
            context.lineTo(point.x, point.y)
            context.closePath()
            context.stroke();
            prevPoint = point;
        }
    }

    // функції обробники подій миші
    const mouseDown = event => {
        isPaint = true
        addPoint(event.pageX, event.pageY);
        redraw();
    }

    // dragging = перетягування
    const mouseMove = event => {
        if(isPaint){
            addPoint(event.pageX, event.pageY, true);
            redraw();
        }
    }

    // додаємо обробку подій
    canvas.addEventListener('mousemove', mouseMove)
    canvas.addEventListener('mousedown', mouseDown)
    canvas.addEventListener('mouseup',() => {
        isPaint = false;
    });
    canvas.addEventListener('mouseleave',() => {
        isPaint = false;
    });

    // TOOLBAR
    const toolBar = document.getElementById('toolbar')
    /* Clear button */
    const clearBtn = document.createElement('button')
    clearBtn.classList.add('btn')
    clearBtn.textContent = 'Clear'
    clearBtn.innerHTML = '<img src="https://img.icons8.com/material-outlined/48/000000/eraser.png" height="48px" width="48px" />';
    
    clearBtn.addEventListener('click', () => {
        // код очистки canvas та масиву точок (clearRect)
        context.clearRect(0, 0, context.canvas.width, context.canvas.height);
        points = [];
        context.drawImage(img, 0, 0);
    })


    /* Download button */
    // opens new page with only .png image
    const downloadBtn = document.createElement('button');
    downloadBtn.classList.add('btn');
    downloadBtn.textContent = 'Download';
    downloadBtn.innerHTML = '<img src="https://img.icons8.com/material-outlined/48/000000/imac-picture.png" height="48px" width="48px" />';

    downloadBtn.addEventListener('click', () => {
        const dataUrl = canvas.toDataURL("image/png").replace(/^data:image\/[^;]/, 'data:application/octet-stream');
        const newTab = window.open('about:blank','Изображение с мольберта');
        newTab.document.write("<img src='" + dataUrl + "' alt='Изображение с мольберта'/>");
    })

    const saveBtn = document.createElement('button');
    saveBtn.classList.add('btn');
    saveBtn.textContent = 'Save';
    saveBtn.innerHTML = '<img src="https://img.icons8.com/material-outlined/48/000000/save.png" height="48px" width="48px" />';


    saveBtn.addEventListener('click', () => {
        console.log(points);
        localStorage.setItem("points", JSON.stringify(points));
    })
    const restoreBtn = document.createElement('button');

    restoreBtn.classList.add('btn');
    restoreBtn.textContent = 'Restore';
    restoreBtn.innerHTML = '<img src="https://img.icons8.com/material-outlined/48/000000/upload--v1.png" height="48px" width="48px" />';
    restoreBtn.addEventListener('click', () => {
        let strings;
        console.log(points);
        points = JSON.parse(localStorage.getItem("points"))
        redraw();
        console.log(points);
    })

    const timeBtn = document.createElement('button');

    timeBtn.classList.add('btn');
    timeBtn.textContent = 'Timestamp';
    timeBtn.innerHTML = '<img src="https://img.icons8.com/material-outlined/48/000000/clock--v1.png" height="48px" width="48px" />';
    timeBtn.addEventListener('click', () => {
        currentData = new Date();
        context.strokeStyle = '';
        context.beginPath();
        context.font = '15px serif';
        context.strokeText(currentData.toString(), 10, 50, rect.width);
        context.closePath();
        context.stroke();
    })

    let color;
    const colorBtn = document.createElement('btn');
    colorBtn.classList.add('btn');
    colorBtn.textContent = 'Change color';
    colorBtn.innerHTML = '<img src="https://img.icons8.com/material-outlined/48/000000/hdd.png" height="48px" width="48px" />';
    colorBtn.addEventListener('click', () => {
        color = document.getElementById("color-picker");
        console.log(color);
        console.log(color.value);
        options.strokeColor = color.value;
    })

    toolBar.insertAdjacentElement('afterbegin', colorBtn);
    toolBar.insertAdjacentElement('afterbegin', timeBtn);
    toolBar.insertAdjacentElement('afterbegin', saveBtn);
    toolBar.insertAdjacentElement('afterbegin', restoreBtn);
    toolBar.insertAdjacentElement('afterbegin', downloadBtn);
    toolBar.insertAdjacentElement('afterbegin', clearBtn);
}