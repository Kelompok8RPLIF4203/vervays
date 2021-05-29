const url =  getEbookURL();

let pdfDoc = null,
  pageNum = 1,
  pageIsRendering = false,
  pageNumIsPending = null;

const scale = 1.5,
  canvas = document.querySelector('#pdf-render'),
  ctx = canvas.getContext('2d');

// Render the page
const renderPage = num => {
  pageIsRendering = true;

  // Get page
  pdfDoc.getPage(num).then(page => {
    //console.log(page);

    // Set Scale
    const viewport = page.getViewport({ scale });
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    const renderCtx = {
      canvasContext : ctx,
      viewport
    }

    page.render(renderCtx).promise.then(() => {
      pageIsRendering = false;

      if (pageNumIsPending !== null) {
        renderPage(pageNumIsPending);
        pageNumIsPending = null;
      }
    });

    // Output curren page
    document.querySelector('#page-num').textContent = num;
  });
};

//Check for page rendering
const queueRenderPage = num => {
  if (pageIsRendering) {
    pageNumIsPending = num;
  }
  else {
    renderPage(num);
  }
};

// Show Prev Page
const showPrevPage = () => {
  if (pageNum <= 1) {
    return;
  }
  pageNum--;
  updateLastRead(pageNum);
  queueRenderPage(pageNum);
};

// Show Next Page
const showNextPage = () => {
  if (pageNum >= pdfDoc.numPages) {
    return;
  }
  pageNum++;
  updateLastRead(pageNum);
  queueRenderPage(pageNum);
};

function updateLastRead(num) {
  var bookId = getBookId();
  var link = "/get/update_last_read/"+bookId+"/"+num;
  // console.log({link});
  $.ajax({
    url : link,
    method : "GET"
  });
}

// Get Document
pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
  pdfDoc = pdfDoc_;
  
  document.querySelector('#page-count').textContent = pdfDoc.numPages;
  $.ajax({
    url : "/get/get_last_read/"+getBookId(),
    method : "GET"
  }).done(function(lastRead) {
    var intLastRead = parseInt(lastRead);
    // console.log({intLastRead});
    if (intLastRead === 0) {
      intLastRead = 1;
    }
    pageNum = intLastRead;
    renderPage(intLastRead);
  });
}).catch(err => {
  // Display error
  const div = document.createElement('div');
  div.className = 'error';
  div.appendChild(document.createTextNode(err.message));
  document.querySelector('body').insertBefore(div, canvas);
  // Remove top bar
  document.querySelector('.top-bar').style.display = 'none';
});

// Button Events
document.querySelector('#prev-page').addEventListener('click', showPrevPage);
document.querySelector('#next-page').addEventListener('click', showNextPage);

function getEbookURL() {
  const metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "ebookURL") {
      return metas[i].getAttribute('content');
    }
  }

  return '';
}

function getBookId() {
  const metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "bookId") {
      return metas[i].getAttribute('content');
    }
  }

  return '';
}