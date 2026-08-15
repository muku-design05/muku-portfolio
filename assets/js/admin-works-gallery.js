jQuery(function ($) {
    const $galleryList = $('#muku-works-gallery-list');
    const $galleryInput = $('#muku-works-gallery-ids');
    const $addButton = $('#muku-works-gallery-add');

    if (
        !$galleryList.length ||
        !$galleryInput.length ||
        !$addButton.length
    ) {
        return;
    }

    /**
     * 現在の画像IDをhiddenへ保存
     */
    const updateGalleryIds = () => {
        const galleryIds = [];

        $galleryList
            .find('.muku-works-gallery__item')
            .each(function () {
                const attachmentId = $(this).data('attachment-id');

                if (attachmentId) {
                    galleryIds.push(attachmentId);
                }
            });

        $galleryInput.val(galleryIds.join(','));
    };

    const updateGalleryPositions = () => {
    const positions = {};

    $galleryList
        .find('.muku-works-gallery__item')
        .each(function () {
            const attachmentId = $(this).data('attachment-id');
            const position = $(this)
                .find('.muku-works-gallery__position')
                .val();

            if (attachmentId && position) {
                positions[attachmentId] = position;
            }
        });

    $('#muku-works-gallery-positions').val(
        JSON.stringify(positions)
    );
    };

    /**
     * サムネイル位置を変更したらhiddenへ反映
     */
    $galleryList.on(
        'change',
        '.muku-works-gallery__position',
        function () {
            updateGalleryPositions();
        }
    );

    /**
     * 画像一覧を並べ替え可能にする
     */
    $galleryList.sortable({
        items: '.muku-works-gallery__item',
        cursor: 'move',
        placeholder: 'muku-works-gallery__placeholder',
        update: updateGalleryIds,
    });

    /**
     * メディアライブラリを開く
     */
    $addButton.on('click', function (event) {
        event.preventDefault();

        const mediaFrame = wp.media({
            title: 'Work Galleryに画像を追加',
            button: {
                text: '画像を追加',
            },
            library: {
                type: 'image',
            },
            multiple: true,
        });

        mediaFrame.on('select', function () {
            const selectedImages = mediaFrame
                .state()
                .get('selection')
                .toJSON();

            const currentIds = $galleryList
                .find('.muku-works-gallery__item')
                .map(function () {
                    return Number($(this).data('attachment-id'));
                })
                .get();

            selectedImages.forEach(function (image) {
                if (currentIds.includes(image.id)) {
                    return;
                }

                const thumbnailUrl =
                    image.sizes?.thumbnail?.url ||
                    image.sizes?.medium?.url ||
                    image.url;

                const galleryItem = `
                        <li
                            class="muku-works-gallery__item"
                            data-attachment-id="${image.id}"
                        >
                            <div class="muku-works-gallery__image">
                                <img
                                    src="${thumbnailUrl}"
                                    alt=""
                                >
                            </div>

                            <label class="muku-works-gallery__position-label">
                                サムネイル位置

                                <select
                                    class="muku-works-gallery__position"
                                    data-attachment-id="${image.id}"
                                >
                                    <option value="center">中央</option>
                                    <option value="top">上</option>
                                    <option value="bottom">下</option>
                                    <option value="left">左</option>
                                    <option value="right">右</option>
                                </select>
                            </label>

                            <button
                                type="button"
                                class="muku-works-gallery__remove"
                                aria-label="画像を削除"
                            >
                                ×
                            </button>
                        </li>
                    `;

                $galleryList.append(galleryItem);
                currentIds.push(image.id);
                
                updateGalleryPositions();
            });

            updateGalleryIds();
        });

        mediaFrame.open();
    });

    /**
     * 画像を削除
     */
    $galleryList.on(
        'click',
        '.muku-works-gallery__remove',
        function (event) {
            event.preventDefault();

            $(this)
                .closest('.muku-works-gallery__item')
                .remove();

            updateGalleryIds();
        }
    );
});