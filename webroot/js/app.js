/**
 * Cookbook App - Main Application JavaScript
 * Vanilla JS replacement for jQuery-based default.js
 */

function initApplication() {
    initAjaxHRef('content');
    initAjaxHRef('navbarMain');
    initAjaxForms('content');
    setupSearchBox();
    loadRecipeBox();

    window.onpopstate = function (event) {
        if (event.state == null)
            return;
        ajaxGet(event.state.action, event.state.target);
    };

    // Modal save button handler
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-save-btn')) {
            var modalEl = e.target.closest('.modal');
            if (modalEl) {
                var bodyEl = modalEl.querySelector('.modal-body');
                if (bodyEl) {
                    var submitBtn = bodyEl.querySelector(':scope [type="submit"], :scope button.btn-primary');
                    if (submitBtn) {
                        submitBtn.click();
                    } else {
                        // Try submitting the form directly
                        var form = bodyEl.querySelector('form');
                        if (form) {
                            form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
                        }
                    }
                }
            }
        }
    });
}

function loadRecipeBox() {
    var desktop = document.getElementById('recipeLinkBoxContainer');
    var mobile = document.getElementById('recipeLinkBoxContainerMobile');

    // Load desktop sidebar using standard ajaxGet
    if (desktop) {
        ajaxGet("recipeLinkBox/index", "recipeLinkBoxContainer");
    }

    // Load mobile offcanvas copy
    if (mobile) {
        var url = baseUrl + "recipeLinkBox/index";
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(response) { return response.text(); })
        .then(function(data) {
            mobile.innerHTML = data;
            executeScripts(mobile);
            initAjax('recipeLinkBoxContainerMobile');
            // Close offcanvas when a link is clicked
            mobile.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    var offcanvasEl = document.getElementById('sidebarOffcanvas');
                    var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                    if (offcanvas) offcanvas.hide();
                });
            });
        })
        .catch(function(error) {
            console.error('[app] loadRecipeBox mobile error:', error);
        });
    }
}

function initAjax(target) {
    initAjaxHRef(target);
    initAjaxForms(target);
}

/**
 * Execute script tags found in AJAX-loaded content.
 * innerHTML doesn't execute scripts, so we need to recreate them.
 */
function executeScripts(container) {
    var containerEl = (typeof container === 'string') ? document.getElementById(container) : container;
    if (!containerEl) return;

    var scripts = containerEl.querySelectorAll('script');
    scripts.forEach(function(oldScript) {
        var newScript = document.createElement('script');
        // Copy attributes
        Array.from(oldScript.attributes).forEach(function(attr) {
            newScript.setAttribute(attr.name, attr.value);
        });
        // Copy inline content
        newScript.textContent = oldScript.textContent;
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });
}

function ajaxGet(location, target) {
    console.log("Starging AJAX Request: " + location);
    target = (target === undefined) ? "content" : target;
    var targetEl = document.getElementById(target);
    if (!targetEl) return;

    targetEl.innerHTML = '<div class="loading-spinner"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><span>Loading...</span></div>';

    if (location.indexOf(baseUrl) != 0) {
        location = baseUrl + location;
    }

    fetch(location, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) {
        if (response.status === 403) {
            ajaxGet(baseUrl + "users/login", target);
            return null;
        }
        if (!response.ok) {
            return response.text().then(function(text) {
                targetEl.innerHTML = text;
                executeScripts(targetEl);
                return null;
            });
        }
        return response.text();
    })
    .then(function(data) {
        if (data === null) return;
        targetEl.innerHTML = data;
        executeScripts(targetEl);
        initAjax(target);
    })
    .catch(function(error) {
        console.error('ajaxGet error:', error);
        targetEl.innerHTML = '<div class="alert alert-danger">An error occurred loading content.</div>';
    });
}

function ajaxPostForm(formEl) {
    var targetId = formEl.getAttribute('targetId') || 'content';

    fetch(formEl.getAttribute('action'), {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: new FormData(formEl)
    })
    .then(function(response) {
        if (response.status === 403) {
            ajaxGet(baseUrl + "users/login", targetId);
            return null;
        }
        return response.text();
    })
    .then(function(data) {
        if (data === null) return;
        var targetEl = document.getElementById(targetId);
        if (targetEl) {
            targetEl.innerHTML = data;
            executeScripts(targetEl);
            initAjax(targetId);
        }
    })
    .catch(function(error) {
        console.error('ajaxPostForm error:', error);
    });
}

function ajaxNavigate(actionUrl, title, targetId) {
    if (actionUrl.indexOf(baseUrl) != 0) {
        actionUrl = baseUrl + actionUrl;
    }

    if (history.pushState) {
        var stateObj = { target: targetId, action: actionUrl };
        history.pushState(stateObj, title, actionUrl);
        ajaxGet(actionUrl, targetId);
    } else {
        window.location.assign(actionUrl);
    }
    return false;
}


function initAjaxHRef(searchId) {
    var findQuery = (searchId === undefined) ? "#content .ajaxLink" : "#" + searchId + " .ajaxLink";
    document.querySelectorAll(findQuery).forEach(function(el) {
        var targetItem = el;
        if (el.tagName !== 'A') targetItem = el.querySelector('a');
        if (!targetItem) return;

        // Avoid double-binding
        if (targetItem.dataset.ajaxBound) return;
        targetItem.dataset.ajaxBound = 'true';
        targetItem.addEventListener('click', function(e) {
            e.preventDefault();
            var targetId = this.getAttribute('targetId');

            // Check if target is a modal
            if (targetId) {
                var targetEl = document.getElementById(targetId);
                if (targetEl && targetEl.classList.contains('modal')) {
                    openModal(targetId);
                } else {
                    closeAllDropdowns();
                }
            } else {
                closeAllDropdowns();
            }

            ajaxNavigate(this.getAttribute('href'), targetId);
            return false;
        });
    });
}

function initAjaxForms(targetId) {
    var findQuery = (targetId === undefined) ? "#content form" : "#" + targetId + " form";
    document.querySelectorAll(findQuery).forEach(function(formEl) {
        // Avoid double-binding
        if (formEl.dataset.ajaxFormBound) return;
        // Allow forms to opt out of AJAX handling
        if (formEl.dataset.noAjax) return;
        formEl.dataset.ajaxFormBound = 'true';

        formEl.addEventListener('submit', function(e) {
            e.preventDefault();
            ajaxPostForm(this);
            return false;
        });
    });
}

// Also bind forms inside modals
function initModalForms(modalId) {
    var modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    var contentEl = modalEl.querySelector('.modal-body');
    if (!contentEl) return;
    contentEl.querySelectorAll('form').forEach(function(formEl) {
        if (formEl.dataset.ajaxFormBound) return;
        formEl.dataset.ajaxFormBound = 'true';
        formEl.addEventListener('submit', function(e) {
            e.preventDefault();
            ajaxPostForm(this);
            return false;
        });
    });
}


function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
        var dropdown = bootstrap.Dropdown.getInstance(menu.previousElementSibling);
        if (dropdown) dropdown.hide();
    });
}

/**
 * Modal Management
 */
function openModal(dialogId) {
    var modalEl = document.getElementById(dialogId);
    if (!modalEl) return;
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();

    // When content loads in a modal, bind its forms and links
    modalEl.addEventListener('shown.bs.modal', function() {
        initModalForms(dialogId);
        initAjaxHRef(dialogId + 'Content');
        initNavigationHRef(dialogId + 'Content');
    }, { once: true });
}

function closeModal(dialogId) {
    var modalEl = document.getElementById(dialogId);
    if (!modalEl) return;
    var modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
}

/**
 * Search Box
 */
function setupSearchBox() {
    var searchInput = document.querySelector('.searchTextBox');
    var cancelBtn = document.querySelector('.cancelBtn');

    if (!searchInput || !cancelBtn) return;

    showCancel();

    cancelBtn.addEventListener('click', function() {
        searchInput.value = '';
        showCancel();
    });

    searchInput.addEventListener('change', showCancel);
    searchInput.addEventListener('keyup', showCancel);

    searchInput.addEventListener('keydown', function(e) {
        if (e.which === 13 || e.key === 'Enter') {
            ajaxGet(window.applicationContext + '/search?term=' + this.value);
            return false;
        }
        showCancel();
    });
}

function setSearchBoxTarget(controllerName) {
    window.applicationContext = controllerName;
    var searchBox = document.querySelector('.searchTextBox');
    if (searchBox) {
        searchBox.setAttribute('placeholder', 'Search ' + controllerName);
        searchBox.focus();
    }
}

function showCancel() {
    var searchInput = document.querySelector('.searchTextBox');
    var cancelBtn = document.querySelector('.cancelBtn');
    if (!searchInput || !cancelBtn) return;

    if (searchInput.value) {
        cancelBtn.classList.add('visible');
    } else {
        cancelBtn.classList.remove('visible');
    }
}

/**
 * Fraction Convert - vanilla version
 */
function fractionConvert(element, numberError) {
    var item = (element instanceof HTMLElement) ? element : element;
    var teststring = item.value;
    var a = teststring.indexOf(",");
    if (a !== -1) {
        teststring = teststring.substring(0, a) + "." + teststring.substring(a + 1, teststring.length);
        item.value = teststring;
    }

    if (isNaN(teststring)) {
        if (teststring.indexOf("/") > 0) {
            var n, f;
            if (teststring.indexOf(" ") > 0) {
                n = teststring.substring(0, teststring.indexOf(" ") + 1);
                f = teststring.substring(teststring.indexOf(" ") + 1);
            } else {
                n = teststring.substring(0, teststring.indexOf("/") - 1);
                f = teststring.substring(teststring.indexOf("/") - 1);
            }
            if (isNaN(n)) { alert(numberError); return; }
            var newArray = f.split("/");
            if (isNaN(newArray[0])) { alert(numberError); return; }
            if (isNaN(newArray[1])) { alert(numberError); return; }
            item.value = (n * 1) + (newArray[0] / newArray[1]);
        } else {
            alert(numberError);
        }
    }
}

/**
 * Toast notifications (replaces toastr)
 */
function showToast(message, type) {
    type = type || 'success';
    var container = document.getElementById('toastContainer');
    if (!container) return;

    var iconClass = 'bi-check-circle';
    var bgClass = 'toast-cookbook';
    if (type === 'error') {
        iconClass = 'bi-exclamation-circle';
        bgClass = 'bg-danger text-white';
    } else if (type === 'warning') {
        iconClass = 'bi-exclamation-triangle';
        bgClass = 'bg-warning text-dark';
    } else if (type === 'info') {
        iconClass = 'bi-info-circle';
        bgClass = 'bg-info text-white';
    }

    var toastHtml = '<div class="toast ' + bgClass + '" role="alert" aria-live="assertive" aria-atomic="true">' +
        '<div class="toast-body d-flex align-items-center gap-2">' +
        '<i class="bi ' + iconClass + '"></i> ' + message +
        '<button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
        '</div></div>';

    container.insertAdjacentHTML('beforeend', toastHtml);
    var toastEl = container.lastElementChild;
    var bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
    bsToast.show();

    toastEl.addEventListener('hidden.bs.toast', function() {
        toastEl.remove();
    });
}

/**
 * Autocomplete - lightweight vanilla implementation
 */
function initVanillaAutocomplete(inputEl, options) {
    if (!inputEl) return;

    var sourceUrl = options.source;
    var minLength = options.minLength || 1;
    var onSelect = options.select;
    var onChange = options.change;
    var autoFocus = options.autoFocus !== undefined ? options.autoFocus : true;

    var dropdown = null;
    var activeIndex = -1;
    var items = [];
    var debounceTimer = null;

    function createDropdown() {
        if (dropdown) return;
        dropdown = document.createElement('div');
        dropdown.className = 'autocomplete-dropdown';
        inputEl.parentNode.style.position = 'relative';
        inputEl.parentNode.appendChild(dropdown);
    }

    function destroyDropdown() {
        if (dropdown) {
            dropdown.remove();
            dropdown = null;
        }
        activeIndex = -1;
        items = [];
    }

    function renderItems(data) {
        createDropdown();
        dropdown.innerHTML = '';
        items = data;
        activeIndex = autoFocus ? 0 : -1;

        data.forEach(function(item, index) {
            var div = document.createElement('div');
            div.className = 'autocomplete-item' + (index === activeIndex ? ' active' : '');
            div.textContent = item.label || item.value || item;
            div.dataset.index = index;

            div.addEventListener('mousedown', function(e) {
                e.preventDefault();
                selectItem(index);
            });

            div.addEventListener('mouseenter', function() {
                activeIndex = index;
                updateActive();
            });

            dropdown.appendChild(div);
        });
    }

    function updateActive() {
        if (!dropdown) return;
        dropdown.querySelectorAll('.autocomplete-item').forEach(function(el, i) {
            el.classList.toggle('active', i === activeIndex);
        });
    }

    function selectItem(index) {
        var item = items[index];
        if (!item) return;

        if (onSelect) {
            var result = onSelect({ target: inputEl }, { item: item });
            if (result !== false) {
                inputEl.value = item.value || item.label || item;
            }
        } else {
            inputEl.value = item.value || item.label || item;
        }
        destroyDropdown();
    }

    inputEl.addEventListener('input', function() {
        var val = this.value;
        if (val.length < minLength) {
            destroyDropdown();
            return;
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            var url = sourceUrl + (sourceUrl.indexOf('?') > -1 ? '&' : '?') + 'term=' + encodeURIComponent(val);
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.length > 0) {
                    renderItems(data);
                } else {
                    destroyDropdown();
                }
            })
            .catch(function() {
                destroyDropdown();
            });
        }, 200);
    });

    inputEl.addEventListener('keydown', function(e) {
        if (!dropdown) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIndex = Math.min(activeIndex + 1, items.length - 1);
            updateActive();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIndex = Math.max(activeIndex - 1, 0);
            updateActive();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (activeIndex >= 0) {
                selectItem(activeIndex);
            }
        } else if (e.key === 'Escape') {
            destroyDropdown();
        }
    });

    inputEl.addEventListener('blur', function() {
        setTimeout(function() {
            if (onChange && items.length === 0) {
                onChange({ target: inputEl }, { item: null });
            }
            destroyDropdown();
        }, 200);
    });

    // Return destroy function for cleanup
    return {
        destroy: destroyDropdown
    };
}

/**
 * Star Rating component
 */
function createStarRating(container, options) {
    options = options || {};
    var value = options.value || 0;
    var readonly = options.readonly || false;
    var maxStars = options.max || 5;
    var step = options.step || 1;
    var onRate = options.onRate;

    container.innerHTML = '';
    container.classList.add('star-rating');
    if (!readonly) container.classList.add('interactive');

    function render(currentValue) {
        container.innerHTML = '';
        for (var i = 1; i <= maxStars; i++) {
            var star = document.createElement('i');
            star.className = i <= currentValue ? 'bi bi-star-fill' : 'bi bi-star';
            star.dataset.value = i;

            if (!readonly) {
                star.addEventListener('click', function() {
                    var newVal = parseInt(this.dataset.value);
                    value = newVal;
                    render(value);
                    if (onRate) onRate(value);
                });

                star.addEventListener('mouseenter', function() {
                    var hoverVal = parseInt(this.dataset.value);
                    highlightStars(hoverVal);
                });

                star.addEventListener('mouseleave', function() {
                    highlightStars(value);
                });
            }

            container.appendChild(star);
        }
    }

    function highlightStars(val) {
        container.querySelectorAll('i').forEach(function(star) {
            var starVal = parseInt(star.dataset.value);
            star.className = starVal <= val ? 'bi bi-star-fill' : 'bi bi-star';
        });
    }

    render(value);

    return {
        getValue: function() { return value; },
        setValue: function(v) { value = v; render(v); }
    };
}

/**
 * Bootstrap Progress Bar helper
 */
function createProgressBar(container) {
    container.innerHTML =
        '<div class="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">' +
        '<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>' +
        '</div>' +
        '<div class="progress-label text-center mt-1 small"></div>';

    var bar = container.querySelector('.progress-bar');
    var label = container.querySelector('.progress-label');
    var max = 100;

    return {
        setMax: function(m) { max = m; },
        setValue: function(val) {
            var percent = Math.min((val / max) * 100, 100);
            bar.style.width = percent + '%';
            container.querySelector('.progress').setAttribute('aria-valuenow', percent);
        },
        setLabel: function(text) { label.textContent = text; },
        show: function() { container.style.display = ''; },
        hide: function() { container.style.display = 'none'; },
        isComplete: function() {
            return parseFloat(bar.style.width) >= 100;
        }
    };
}
