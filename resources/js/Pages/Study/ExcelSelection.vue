<template>
    <div>
        <!-- 메인 제목 -->
        <div class="flex flex-col items-start mb-6">
            <h1 class="text-3xl font-bold text-black">ບົດທີ 5: <span class="text-blue-600">ເທັກນິກການເລືອກ</span></h1>
            <!-- 제5과: 선택 기술 -->
        </div>

        <!-- 소개 -->
        <div class="flex flex-wrap justify-between items-start mb-6">
            <p class="text-lg text-black w-full">
                ການເລືອກຂໍ້ມູນໃນ Excel ແມ່ນຫຍັງທີ່ຈໍາເປັນສໍາລັບການໃຊ້ງານລາຍງານ, ວິເຄາະຂໍ້ມູນ ແລະ ການຄິດໄລສູດ.
            </p>
            <!-- Excel에서 데이터를 선택하는 것은 보고서 작성, 데이터 분석 및 수식 계산을 위한 필수 과정입니다. -->
        </div>

        <!-- 소제목 5.4.1 -->
        <div class="flex flex-col items-start mb-4">
            <h2 class="text-2xl font-bold text-black">5.4.1 <span class="text-blue-600">ການເລືອກ Cell ເດີ່ນດຽວ</span></h2>
            <!-- 5.4.1. 단일 셀 선택 -->
        </div>

        <!-- 단일 셀 선택 방법 -->
        <div class="flex flex-wrap justify-between items-start mb-6">
            <p class="text-lg text-black w-full">
                ກົດໃສ່ Cell ທີ່ຕ້ອງການເລືອກ ແລ້ວຈະປະກົດຂອບເສັ້ນສີນ້ໍາເງິນລອບ Cell.
            </p>
            <!-- 원하는 셀을 클릭하면 파란색 테두리가 나타나며 선택됩니다. -->
        </div>

        <!-- 이미지 -->
        <div class="flex justify-center my-6">
            <img src="/images/study/55p_2.jpg" alt="단일 셀 선택" class="border rounded-lg shadow-md w-full max-w-lg" />
        </div>

        <!-- 그림 설명 -->
        <div class="flex flex-col items-center">
            <p class="text-sm text-gray-500">ຮູບ 5.7: ການເລືອກ Cell ທີ່ຕ້ອງການ</p>
            <!-- 그림 5.7: 선택할 셀 클릭 -->
        </div>

        <!-- 소제목 5.4.2 -->
        <div class="flex flex-col items-start mb-4">
            <h2 class="text-2xl font-bold text-black">5.4.2 <span class="text-blue-600">ການເລືອກ Cell ຫຼາຍໂຕ</span></h2>
            <!-- 5.4.2 여러 개의 셀 선택 -->
        </div>

        <!-- 여러 개의 셀 선택 방법 -->
        <div class="flex flex-wrap justify-between items-start mb-6">
            <p class="text-lg text-black w-full">
                ທ່ານສາມາດເລືອກ Cell ຫຼາຍໂຕໄດ້ໂດຍກົດໃສ່ Cell ແລ້ວລາກເມົ້າໄປຍັງຂອບ Cell ທີ່ຕ້ອງການເພີ່ມ.
            </p>
            <!-- 여러 개의 셀을 선택하려면 첫 번째 셀을 클릭한 후 마우스를 드래그하여 범위를 확장하면 됩니다. -->
        </div>

        <!-- 이미지 -->
        <div class="flex justify-center my-6">
            <img src="/images/study/56p_1.jpg" alt="여러 개의 셀 선택" class="border rounded-lg shadow-md w-full max-w-lg" />
        </div>
        <div class="flex justify-center my-6">
            <img src="/images/study/56p_2.jpg" alt="여러 개의 셀 선택" class="border rounded-lg shadow-md w-full max-w-lg" />
            <img src="/images/study/57p_1.jpg" alt="여러 개의 셀 선택" class="border rounded-lg shadow-md w-full max-w-lg" />
        </div>

        <!-- 그림 설명 -->
        <div class="flex flex-col items-center">
            <p class="text-sm text-gray-500">ຮູບ 5.8: ການເລືອກ Cell ຫຼາຍໂຕ</p>
            <!-- 그림 5.8: 여러 개의 셀 선택 -->
        </div>

        <!-- 소제목 5.4.3 -->
        <div class="flex flex-col items-start mb-4">
            <h2 class="text-2xl font-bold text-black">5.4.3 <span class="text-blue-600">ການເລືອກ WorkSheet</span></h2>
            <!-- 5.4.3 워크시트 선택 -->
        </div>

        <!-- 워크시트 선택 방법 -->
        <div class="flex flex-wrap justify-between items-start mb-6">
            <p class="text-lg text-black w-full">
                ການເລືອກ WorkSheet ແມ່ນສໍາຄັນ ສໍາລັບການຈັດການແລະເຂົ້າເຖິງຂໍ້ມູນໃນ Excel.
            </p>
            <!-- 워크시트를 선택하는 것은 엑셀에서 데이터를 관리하고 접근하는 데 중요한 기능입니다. -->
        </div>

        <!-- 이미지 -->
        <div class="flex justify-center my-6">
            <img src="/images/study/57p_2.jpg" alt="워크시트 선택" class="border rounded-lg shadow-md w-full max-w-lg" />
        </div>

        <!-- 그림 설명 -->
        <div class="flex flex-col items-center">
            <p class="text-sm text-gray-500">ຮູບ 5.11: ການເລືອກ WorkSheet</p>
            <!-- 그림 5.11: 워크시트 선택 -->
        </div>

        <!-- 소제목 5.4.4 -->
        <div class="flex flex-col items-start mb-4">
            <h2 class="text-2xl font-bold text-black">5.4.4 <span class="text-blue-600">ການເລືອກ Cell ທີ່ບໍ່ຕິດກັນ</span></h2>
            <!-- 5.4.4 떨어진 셀 선택 -->
        </div>

        <!-- 떨어진 셀 선택 방법 -->
        <div class="flex flex-wrap justify-between items-start mb-6">
            <p class="text-lg text-black w-full">
                ທ່ານສາມາດເລືອກ Cell ທີ່ບໍ່ຕິດກັນໄດ້ໂດຍກົດໃສ່ Cell ທີ່ຕ້ອງການກ່ອນ, ຈາກນັ້ນກົດ Ctrl ແລ້ວກົດເພີ່ມ Cell ທີ່ອື່ນໆ.
            </p>
            <!-- 떨어진 셀을 선택하려면 먼저 하나의 셀을 선택한 후 Ctrl 키를 누른 상태에서 추가 셀을 클릭하면 됩니다. -->
        </div>

        <!-- 이미지 -->
        <div class="flex justify-center my-6">
            <img src="/images/study/58p_1.jpg" alt="떨어진 셀 선택" class="border rounded-lg shadow-md w-full max-w-lg" />
        </div>

        <!-- 그림 설명 -->
        <div class="flex flex-col items-center">
            <p class="text-sm text-gray-500">ຮູບ 5.12: ການເລືອກ Cell ທີ່ບໍ່ຕິດກັນ</p>
            <!-- 그림 5.12: 떨어진 셀 선택 -->
        </div>
    </div>
</template>
