<?php
require_once('wp-load.php');
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/image.php' );

$urls = [
"https://drive.google.com/file/d/1-QvC5BqOoFrJvdNvJ-hQirXrWczqHDO0/view?usp=sharing",
"https://drive.google.com/file/d/1-apvnEyO9XnyBn2mgN0tWevELZ-85FUg/view?usp=sharing",
"https://drive.google.com/file/d/1-gW3wQEZG-T1NKvbAal38cnjUqSas9rW/view?usp=sharing",
"https://drive.google.com/file/d/1-mIgTNYJuGWjX6nQodDK6rm6U4b7a_9p/view?usp=sharing",
"https://drive.google.com/file/d/1-ug-LTj5LN0WH7B-tCt9NWlHDbUJsnz8/view?usp=sharing",
"https://drive.google.com/file/d/101-hzKr1jZpfn5r7tQ5gWci-s3OzlSQI/view?usp=sharing",
"https://drive.google.com/file/d/109aARXLu9tpS2g-lTtRjqAMEbn_Zl6rQ/view?usp=sharing",
"https://drive.google.com/file/d/10CioTt-y28QN0yIhOBqEOh8uzouqSoQo/view?usp=sharing",
"https://drive.google.com/file/d/10PdhWhA_jdEBsvBdBxs7eaiRwv5sb8Oc/view?usp=sharing",
"https://drive.google.com/file/d/10ULvrh-9kfn4tC4fcYNd7FPhIfN9NXlT/view?usp=sharing",
"https://drive.google.com/file/d/11-HOXtIIgj9M1PYqV_IahoSGp8BuOWog/view?usp=sharing",
"https://drive.google.com/file/d/1117ca9bL7Vrln5DuM14N9bsUSDiP3poF/view?usp=sharing",
"https://drive.google.com/file/d/11I7yYxFFmYoEzvtneRgThoSKf_2p5FdA/view?usp=sharing",
"https://drive.google.com/file/d/11OpruMYsvATi8c8zNBKr3BAygif4034q/view?usp=sharing",
"https://drive.google.com/file/d/11f3QMYjQOjTyZZyv6PN6h8d79NgxzyW3/view?usp=sharing",
"https://drive.google.com/file/d/11nKDCGi8haq1-3sYbCDRTDiT8anOmNmQ/view?usp=sharing",
"https://drive.google.com/file/d/11nYXNwpbyUVYjTemry8WEIWRQsjtxJ6G/view?usp=sharing",
"https://drive.google.com/file/d/12Au8n8qGo55CyOyEMgXZY3BwKGQVks_5/view?usp=sharing",
"https://drive.google.com/file/d/12lybB3tH-geCkJk921BAfPozrCbxSnmC/view?usp=sharing",
"https://drive.google.com/file/d/12m-FLDHC1Gyik-cPJMLa4Gh11-eOI-xq/view?usp=sharing",
"https://drive.google.com/file/d/12uFqrcnegKF9PeSr5uY2gc4fU9yN9Xld/view?usp=sharing",
"https://drive.google.com/file/d/13skUwlgHrJ3qUUKs2OrB0lCfix6DZnsj/view?usp=sharing",
"https://drive.google.com/file/d/14GFyJVF2L04IXYLwuBWf9H93pzWy3PNH/view?usp=sharing",
"https://drive.google.com/file/d/14Tmqvj9gzrenLYwxLx4uKei1Eene3RGX/view?usp=sharing",
"https://drive.google.com/file/d/14_bIuvPTkM_ZOq5b232Ed_N2pxCqVJHE/view?usp=sharing",
"https://drive.google.com/file/d/14i_WMECed2w-2iC2DTBVXC9RfYgsfY7p/view?usp=sharing",
"https://drive.google.com/file/d/15DDEf1qKNPsjz0RvVHfVw6lB_FzwmTz-/view?usp=sharing",
"https://drive.google.com/file/d/15G_1urPIC1vlWLUWmQRScZh5_mH8Mm46/view?usp=sharing",
"https://drive.google.com/file/d/15IF0z7qgp2AbWPWsZlBzOphnAU9UxpZy/view?usp=sharing",
"https://drive.google.com/file/d/15JBGhwELahGv70Qz4dj6FOqA8pKMgfxM/view?usp=sharing",
"https://drive.google.com/file/d/15XmEIR9y6-hYDwNdRrcxOB52REXqmtB6/view?usp=sharing",
"https://drive.google.com/file/d/15_zaMuI4bFTJ6My1N2AOp3IC2rF3NFU3/view?usp=sharing",
"https://drive.google.com/file/d/15w7ZUqw4yFqRqDaGtZNkQsQG_XXBGWm2/view?usp=sharing",
"https://drive.google.com/file/d/164VWgF4-Fd26y9V8c2kbMRZlSnE7zpYm/view?usp=sharing",
"https://drive.google.com/file/d/16B2fd_iGLo_Du114Crxx_LkhJP9ijzI2/view?usp=sharing",
"https://drive.google.com/file/d/16R1Yjplubf3ftFTTNCngCgGl_qVBK9zT/view?usp=sharing",
"https://drive.google.com/file/d/16hEOsqvWTISGBE_TaSxU9MmqwjXVIuPs/view?usp=sharing",
"https://drive.google.com/file/d/16iUqnyklcgusVxZwpzZrLIIkt2qnqgWP/view?usp=sharing",
"https://drive.google.com/file/d/16qNJSo7wbG4yuCpk3VrPL01bFvxyF0vM/view?usp=sharing",
"https://drive.google.com/file/d/16wGbk3VdP73UH2UvV88vg4e5qAT01eFw/view?usp=sharing",
"https://drive.google.com/file/d/17b2eOYEe51nb9NlmxYVNOmdnwHBxliVv/view?usp=sharing",
"https://drive.google.com/file/d/17dn6UEhhBEq6DVcKdWNtf-z6Kcs-GR9Q/view?usp=sharing",
"https://drive.google.com/file/d/18gCP-zDWDs8ReWuV80M7xeJo5pzx_zxV/view?usp=sharing",
"https://drive.google.com/file/d/19Bfs3YhVcRj7qF9BLSkb9cNcSqHPmUdD/view?usp=sharing",
"https://drive.google.com/file/d/19NLNZnHd7aTBeKwacnQ9vIPcX7QWlFQq/view?usp=sharing",
"https://drive.google.com/file/d/19NLye5-QOpy4KrEr_vcJl2QqeetBANpv/view?usp=sharing",
"https://drive.google.com/file/d/19UEwURQP-K7wQl82Okh4fjV_llY0BiI9/view?usp=sharing",
"https://drive.google.com/file/d/19V4BThI1Wj7uUJgUoVs58U3QhzQys9mH/view?usp=sharing",
"https://drive.google.com/file/d/19XNymeC6mQTSabQQxNVYLNkMQRBGJfXx/view?usp=sharing",
"https://drive.google.com/file/d/19Z3SonPip7acB-O-yPETK28iu2sjguOR/view?usp=sharing",
"https://drive.google.com/file/d/19kuwYnoYo5M4g7GUj6Y5X7K8NMgA5Q4_/view?usp=sharing",
"https://drive.google.com/file/d/19mYRVs8H7UZVAYhSm3aavHOgrgDwMfKM/view?usp=sharing",
"https://drive.google.com/file/d/1A0zYkdAVB31Tl-S6bE_4TptBQXOyHU2y/view?usp=sharing",
"https://drive.google.com/file/d/1A3tIxRVP4N2VPY7doiACdoQ9aU9Cp71l/view?usp=sharing",
"https://drive.google.com/file/d/1AD-I2fXvlToMba708_DrfaUT9B7_Rc-S/view?usp=sharing",
"https://drive.google.com/file/d/1AS5Sfyi66IiPuZxwn8MFXD8CFZOdOX90/view?usp=sharing",
"https://drive.google.com/file/d/1Ab8fpxQkWXckrboObX8tqmewGINpNmJP/view?usp=sharing",
"https://drive.google.com/file/d/1AkiZjbL1TYnaCdjdQObUV3D2lOTUyUXR/view?usp=sharing",
"https://drive.google.com/file/d/1AyoqT0HOFrVGB6O4SlkuXw-7kr-ejI2h/view?usp=sharing",
"https://drive.google.com/file/d/1B-5iexiwWzENtTFKtdft7dfCyMh_xmv6/view?usp=sharing",
"https://drive.google.com/file/d/1B8HjM3j96J1r4wmAkrC8ir3ruS1tf_sr/view?usp=sharing",
"https://drive.google.com/file/d/1BI_tzBkcE2ufPbtXRySQ_-16pqoumMfY/view?usp=sharing",
"https://drive.google.com/file/d/1BPLfpZM9iXjgPsPdzNu-fMhUB6bZ65zJ/view?usp=sharing",
"https://drive.google.com/file/d/1BVTUm5c6-QAg0MynSfE9B8ZbP8ozzyLk/view?usp=sharing",
"https://drive.google.com/file/d/1BfTQZOCBXmB4Y0aG1lq4XECjPjROZgfz/view?usp=sharing",
"https://drive.google.com/file/d/1BiTsx8DAjYh2J9T23BqEzEl5UXpEyI87/view?usp=sharing",
"https://drive.google.com/file/d/1BnqPJAW7ffeHmKi4IApbU6R1lrwhKkWW/view?usp=sharing",
"https://drive.google.com/file/d/1BpzdKbu7O9ODdmq8xgArhic4uSQiu7FD/view?usp=sharing",
"https://drive.google.com/file/d/1BsKUaBcvKlcM5C50zBjY7LhtSy8hmifZ/view?usp=sharing",
"https://drive.google.com/file/d/1C1CuVp9FFUV42rwS7xUooWcbHq-IJECI/view?usp=sharing",
"https://drive.google.com/file/d/1CS-hywBg3sV2qaCBPKNlbccbZ5N8AUNV/view?usp=sharing",
"https://drive.google.com/file/d/1CaSLq3hLc1ZHqFUkh7MXvsjgAc1Q7LA6/view?usp=sharing",
"https://drive.google.com/file/d/1CnP0TAmCvgtWSQoZsAeclNEEJ8T6lkaP/view?usp=sharing",
"https://drive.google.com/file/d/1D3DWToKc7z_YLiMAXpuZUs4nw20-GLjW/view?usp=sharing",
"https://drive.google.com/file/d/1DBE5c9h46yl59R1apENt7g8Ik2j-yntF/view?usp=sharing",
"https://drive.google.com/file/d/1DCBZo7Rzc7Ry5fwBIeR80-p5L0WYmWiI/view?usp=sharing",
"https://drive.google.com/file/d/1DCZ4v5jT4IucHohf7JQfZn_ayGZeGfJH/view?usp=sharing",
"https://drive.google.com/file/d/1Db0GM8A3FicNQZKrUlV1GyD-6SK1TvKX/view?usp=sharing",
"https://drive.google.com/file/d/1DxGLJMcgNMobkhrKtQTgLcajqAppv_FR/view?usp=sharing",
"https://drive.google.com/file/d/1ExRNAqHGB4bsooR1DJLijTSop3SAtqmn/view?usp=sharing",
"https://drive.google.com/file/d/1F21WqtVogjTYBBu11ATAOJyAh6fFlQRT/view?usp=sharing",
"https://drive.google.com/file/d/1FH_cHpRtVamO9r_y_EU8himso3gn9Lcr/view?usp=sharing",
"https://drive.google.com/file/d/1FxPPNA_1pHtSytgJ254YjrgOtulib3XE/view?usp=sharing",
"https://drive.google.com/file/d/1G02yMGDhDTQJYjUUj0xFbjCBoW5Sig7x/view?usp=sharing",
"https://drive.google.com/file/d/1G0RtAoDMM4Zsfi5WP9faqWCDf9hEf0-n/view?usp=sharing",
"https://drive.google.com/file/d/1GQclUazdbuIrzH6NXBpL5fpBGTudg4Vy/view?usp=sharing",
"https://drive.google.com/file/d/1GUEQtvQnX1TuiJ4QCHKntfo_Xpr92KRT/view?usp=sharing",
"https://drive.google.com/file/d/1GYIOuySdrf9qjCjJYL3gWouRr6l0lvx7/view?usp=sharing",
"https://drive.google.com/file/d/1GYtK_RqzU1YdY7w59xrzxnc44TJu4jsZ/view?usp=sharing",
"https://drive.google.com/file/d/1GaW6MO8utXHcDOFwUkFoThYIc2bOvuTm/view?usp=sharing",
"https://drive.google.com/file/d/1GjhY8yqDdtGNvLFrN0WCU1TiNDmoZz-v/view?usp=sharing",
"https://drive.google.com/file/d/1GvJw6F9GZSmSdfeeu1RjUx9ne8fhZyWF/view?usp=sharing",
"https://drive.google.com/file/d/1HKt1VALfl_UlwY_UpmJznWvEbpL6SoWT/view?usp=sharing",
"https://drive.google.com/file/d/1HeYaf59rAL1gVg2VsxZ07TJWVQjCqa7N/view?usp=sharing",
"https://drive.google.com/file/d/1HlrymmFEX3l5_SgIUmV3yc3rRYT1-qTp/view?usp=sharing",
"https://drive.google.com/file/d/1HsB30jMsN1sFKSs4ro4CbH7tKQCHfRYA/view?usp=sharing",
"https://drive.google.com/file/d/1I5Ui9Vo945qorVaJt2ioWc-mpJp4FB0U/view?usp=sharing",
"https://drive.google.com/file/d/1IFpoxEPncGhGmqPwHlvOY0QEkgk2yuJ5/view?usp=sharing",
"https://drive.google.com/file/d/1IQW14tUZuaU5p19b3bWq_ZKtE6zfA8sa/view?usp=sharing",
"https://drive.google.com/file/d/1IZECMXP5k1-HuD3fFrNRs6UiBG4vE0W9/view?usp=sharing",
"https://drive.google.com/file/d/1IdK134G1VqIjdA0s21fIzzGDj9u7AmDc/view?usp=sharing",
"https://drive.google.com/file/d/1IrotWBCeyL2540FLv2qQXtJyjLBqCUhE/view?usp=sharing",
"https://drive.google.com/file/d/1Iu61QVwI10mGtzb2i400tMcxck4GNKLg/view?usp=sharing",
"https://drive.google.com/file/d/1J6LYTGKY7d5IASYYUX6jEqkgVaziYIaz/view?usp=sharing",
"https://drive.google.com/file/d/1JaOm7OtEkB7uuGbURtb2Jm_bYbr-NFNk/view?usp=sharing",
"https://drive.google.com/file/d/1JbBK-c1EhlkQZzFwSZE9iZbscCZLw5RV/view?usp=sharing",
"https://drive.google.com/file/d/1Jm83pqxEcRGQtatn6KHxLcPItxOQCmrx/view?usp=sharing",
"https://drive.google.com/file/d/1Joi-nQd1CbBFVN98jDXTrSz5W21VQlqC/view?usp=sharing",
"https://drive.google.com/file/d/1Jw2LKE5IXtCJAJChximQqRzDGMPEjUbM/view?usp=sharing",
"https://drive.google.com/file/d/1K32lQ0o_drFMoCZS0rHNnQGDUdhsNP_p/view?usp=sharing",
"https://drive.google.com/file/d/1KA-2D1zQWmHcDzdWlqslJYtr7D_3xRWi/view?usp=sharing",
"https://drive.google.com/file/d/1KdQLnANlSh9IcjEOHpNRuroM47sHuGcK/view?usp=sharing",
"https://drive.google.com/file/d/1KwIAXzKRBzApSe6uW4BQtlRVhhqricf1/view?usp=sharing",
"https://drive.google.com/file/d/1LQHVhNasGK-gitxwqiWZmLmoSA2Rdzxp/view?usp=sharing",
"https://drive.google.com/file/d/1LmGEMIh2g9jIkx-ReT7OLAiVmErDPdIE/view?usp=sharing",
"https://drive.google.com/file/d/1Ln71RagSl4z3_Zu0HrGoWCjONMu0WMxw/view?usp=sharing",
"https://drive.google.com/file/d/1LpXR17DAcuBe7rftPL5Top4GZENLTqVn/view?usp=sharing",
"https://drive.google.com/file/d/1LuTwEVybAoGhUjmSrz8DcBNl-897pcXU/view?usp=sharing",
"https://drive.google.com/file/d/1MVr1PfFmm2-Zam1UCzkmIcfpBh7lbL_x/view?usp=sharing",
"https://drive.google.com/file/d/1M_1Kiuyu0jzHP_u-6AdddAf3FiElPqWV/view?usp=sharing",
"https://drive.google.com/file/d/1MnS98NhzkUjHTE4MxA1sSIOZbALqq9PV/view?usp=sharing",
"https://drive.google.com/file/d/1N6k3OfUQ2KMxiiibHCyqux2eOD2AgwY6/view?usp=sharing",
"https://drive.google.com/file/d/1NC2y5TNqAfJHii2q_o8PgzIFJqTKBGDc/view?usp=sharing",
"https://drive.google.com/file/d/1NFB6897st_IzXPzc5XBZefQlt1osMnjY/view?usp=sharing",
"https://drive.google.com/file/d/1NIDt10V_To0xuJglBUZ-u7uGzVozku7A/view?usp=sharing",
"https://drive.google.com/file/d/1NO0UuaOw83lESIij0YqxzujEsQ27_aqG/view?usp=sharing",
"https://drive.google.com/file/d/1NTWgxzvcX9eXMHVFw-fy9wxsw2HEWqw7/view?usp=sharing",
"https://drive.google.com/file/d/1NoZ2Z7WO0eHuxS6-Kpl3BvX5zuWEe8lC/view?usp=sharing",
"https://drive.google.com/file/d/1Nqt4qjqNLtRUJhvMCen6cYIfmdtSkAHc/view?usp=sharing",
"https://drive.google.com/file/d/1Nqu43DTjnnZX9c7mhLb3X8J3k2t0hJ_J/view?usp=sharing",
"https://drive.google.com/file/d/1OPXmzhzQkH-JhWYGoKmeIl813dXwUBSl/view?usp=sharing",
"https://drive.google.com/file/d/1OXqvA6CK-QtZ-LdPPq-akGHObTnHkWZf/view?usp=sharing",
"https://drive.google.com/file/d/1OrScj-Iqm87KTkgAtETRdOtOH9FVJuev/view?usp=sharing",
"https://drive.google.com/file/d/1P9SIuuvvKfAypN6lC-RAg_LVvD6AcKT4/view?usp=sharing",
"https://drive.google.com/file/d/1PYd8320O1GUNEfXluAWEM27lG2eJgSD_/view?usp=sharing",
"https://drive.google.com/file/d/1PrnJn3JyPR_uPPVKjvb6UuvqFaVKHIPi/view?usp=sharing",
"https://drive.google.com/file/d/1QIg8YKgafvM8sz9MalBZL9Dc0BrHdOuq/view?usp=sharing",
"https://drive.google.com/file/d/1QN2xe2E_hozWbks3nXhnWRWZ897zXVRC/view?usp=sharing",
"https://drive.google.com/file/d/1QX2iANxI-wyYBrIR417juI9_iIZQLOOM/view?usp=sharing",
"https://drive.google.com/file/d/1Q_6jZTWrVxTTJT3qT5T9ppFFTXiI6Osb/view?usp=sharing",
"https://drive.google.com/file/d/1QskO4VEQpOwwZFUi6SgESBGN-GePmTv-/view?usp=sharing",
"https://drive.google.com/file/d/1RNmHhR_4WWkL4jea8ZHiAYc733HDgYbR/view?usp=sharing",
"https://drive.google.com/file/d/1SNA1WWjfU9i_7W1JDodw6QuBQnVCMg4h/view?usp=sharing",
"https://drive.google.com/file/d/1SUf6YrXDGip6onXcLFgRp18OTY2wL_9L/view?usp=sharing",
"https://drive.google.com/file/d/1SkFppzb7KWzfm4yRpPVvnImGE0vQtCFL/view?usp=sharing",
"https://drive.google.com/file/d/1SoH__1xEAF4X-EHv5LhRUuz-kHCKODqZ/view?usp=sharing",
"https://drive.google.com/file/d/1SpDD6frR_QLrqB6CcBj5hgLZWiVcWlEy/view?usp=sharing",
"https://drive.google.com/file/d/1SqMswpTsj1S6bs0_vVbEVdjRBFikNdaT/view?usp=sharing",
"https://drive.google.com/file/d/1StlAYBK2jELPU86GWkaYfvaOWFWJRZ5j/view?usp=sharing",
"https://drive.google.com/file/d/1T0i6AT5GAl3wGzGvx99tpMwwYlIMyZ8G/view?usp=sharing",
"https://drive.google.com/file/d/1T1C0le6d7guMRA4HfqYoc3mTy1TaRopy/view?usp=sharing",
"https://drive.google.com/file/d/1TMWHVyTufVP3QX7rQpAsfYPIEfWD918F/view?usp=sharing",
"https://drive.google.com/file/d/1TVpBpwYhzN-Ub83I6HFXTPGZivXozDCx/view?usp=sharing",
"https://drive.google.com/file/d/1TnWzIGD0v8N-3TXSxtPtSnODirE36XF9/view?usp=sharing",
"https://drive.google.com/file/d/1ToIebQH9N8Gi2P0xDNdGcN876pZ58suH/view?usp=sharing",
"https://drive.google.com/file/d/1U5IPvVVwnn-aYC5h3dDD8qRkhLGUQ-pi/view?usp=sharing",
"https://drive.google.com/file/d/1UBSP4CVlPnUatK8D_QsqTu78bIEw6vJv/view?usp=sharing",
"https://drive.google.com/file/d/1UhqO3_SuiGnpO5tAKStWEfqIOQGL_JS4/view?usp=sharing",
"https://drive.google.com/file/d/1UiJIYIv8uflpI_Ewb7JbgtTZ3f-bN8MZ/view?usp=sharing",
"https://drive.google.com/file/d/1UwCg8IKbhpUkFNnB8GKlXb1B_jm5x2ZD/view?usp=sharing",
"https://drive.google.com/file/d/1Uxpk3rS78fqZkqdo1k1GEtQbxWRsRyWi/view?usp=sharing",
"https://drive.google.com/file/d/1VW1orERlz3XTcj8hzPUWpW-KrDC823xf/view?usp=sharing",
"https://drive.google.com/file/d/1Vg7zgnFv_bZMonhu9dimxKY57n0D0xAx/view?usp=sharing",
"https://drive.google.com/file/d/1W4q180mnxUd3jRq9jzXdk3BQnjPJ4Jsv/view?usp=sharing",
"https://drive.google.com/file/d/1WIigeJpFz7SAyCLyLsv4Yg0o-oSf2E3k/view?usp=sharing",
"https://drive.google.com/file/d/1WLx_35s7RxfyJ4b-XP-VwcmOoz00YY3p/view?usp=sharing",
"https://drive.google.com/file/d/1WRel1Fk62MKfxUSPHdOEUAWVN4VSLE3K/view?usp=sharing",
"https://drive.google.com/file/d/1WhbaYN8zt1QD3hKLQKf7PMCJdShebLMe/view?usp=sharing",
"https://drive.google.com/file/d/1Wji8-bJ63P6XBIelCxB2p2WEWiNAbFhI/view?usp=sharing",
"https://drive.google.com/file/d/1WnxYC_BSXDBLCYFBtvbuJJ2sIacNQofJ/view?usp=sharing",
"https://drive.google.com/file/d/1WtvONKuXSYq-aoIWTT3EwQ4nsYl8dufl/view?usp=sharing",
"https://drive.google.com/file/d/1XANwXBOvsStckaO18MrGRHER4kY9b_Fr/view?usp=sharing",
"https://drive.google.com/file/d/1XddVFrZPEd66PMzXxCi9dxmzi3DR5XWo/view?usp=sharing",
"https://drive.google.com/file/d/1Y-x2n_XzK96lwKL8G8jHDUwgQFOqx07q/view?usp=sharing",
"https://drive.google.com/file/d/1YC86trhrEy0oBloG_sj6A_G1NdEYTvRO/view?usp=sharing",
"https://drive.google.com/file/d/1YHzw_ZoXmwZBwuNcOJkrNYz9QCztQlpZ/view?usp=sharing",
"https://drive.google.com/file/d/1YjGomcsKJ6di4NbhkLkm8NEsuQ4grile/view?usp=sharing",
"https://drive.google.com/file/d/1YlP1iD6XDubZQD83rVcXedlBiAQiUIze/view?usp=sharing",
"https://drive.google.com/file/d/1Yo7t3VShmt8pdL53bHQoej0ZabmL1Q8y/view?usp=sharing",
"https://drive.google.com/file/d/1Z8_1lm72xfJVobud8b9a2ZQBo_Fu0H6o/view?usp=sharing",
"https://drive.google.com/file/d/1ZUl1JCgCG7ICf3znn4dKqNKp1-O1Me01/view?usp=sharing",
"https://drive.google.com/file/d/1ZVcGUslgOOHmBNXRV5KO8v8FSJxWD3Av/view?usp=sharing",
"https://drive.google.com/file/d/1ZetFJxRxV6ilAAubRipXoEw51y6vgEPL/view?usp=sharing",
"https://drive.google.com/file/d/1Zh2GAQ_U8rmRY4uq-kNyhiZ0HPKIfShj/view?usp=sharing",
"https://drive.google.com/file/d/1ZrGqu0VgtgiDZqJDspbH6pvWaAW35lhy/view?usp=sharing",
"https://drive.google.com/file/d/1ZyCtPrH_Bim2_kQ7D79L1tt8iKgJPDrv/view?usp=sharing",
"https://drive.google.com/file/d/1_6_-xLFhgEC5SYs8rmLVBeGtAvFs61cD/view?usp=sharing",
"https://drive.google.com/file/d/1_TX_GuKUdtFRdbGnbtw3ckAcepCy3-H_/view?usp=sharing",
"https://drive.google.com/file/d/1_XrwDK8gvkMNpvnxcf5GP3HaOR6G2TP2/view?usp=sharing",
"https://drive.google.com/file/d/1_gn_FxRpLzAr4BgeN7rAlAfk4zgndRc2/view?usp=sharing",
"https://drive.google.com/file/d/1a0b1GMU_9cpM3iJiwEW9rtmBuwA7-OXc/view?usp=sharing",
"https://drive.google.com/file/d/1aKS7FqYQl5CKj5UVC1I3liIhtsN8rQFa/view?usp=sharing",
"https://drive.google.com/file/d/1amXawDx0kG6sbcVm-PZQf592ho0G74n1/view?usp=sharing",
"https://drive.google.com/file/d/1b1OWlELneigbeOS_30c8U5wQBjrSHK4E/view?usp=sharing",
"https://drive.google.com/file/d/1b2psYoiF7NrgBKcxGwGZQNYYwQlstwg0/view?usp=sharing",
"https://drive.google.com/file/d/1bA-FtwTdkXi8puBYkEuHb5JK-3GxVC2P/view?usp=sharing",
"https://drive.google.com/file/d/1bTjskt-OEvoBi32RgEgIm-YOKaoVVXxJ/view?usp=sharing",
"https://drive.google.com/file/d/1b_ZCJI_gRNcMTkxCLPeEd2eyhBP5NSNr/view?usp=sharing",
"https://drive.google.com/file/d/1bk1GDs41qJy3RZGgmM52cG2x9MgUM2C3/view?usp=sharing",
"https://drive.google.com/file/d/1c8cl4jy2b_6eJXelQFJbqgfu0aQi7_99/view?usp=sharing",
"https://drive.google.com/file/d/1cOE8O3IQMaLrlqWluYWNBnudb-5vq-z-/view?usp=sharing",
"https://drive.google.com/file/d/1cVSJ3zWRLRvCOFtjENlfLM8WVmKLQ4jN/view?usp=sharing",
"https://drive.google.com/file/d/1cuqffSBw7UZ80FlLGhhxku8IoY6vPi90/view?usp=sharing",
"https://drive.google.com/file/d/1d3nuy46rAJ5sxoGdSQ7oSZ53rCpPyb4F/view?usp=sharing",
"https://drive.google.com/file/d/1dBpRv62JpsBC7OJz2H-_gevb4PwPjPum/view?usp=sharing",
"https://drive.google.com/file/d/1dOkA_lfDPYVIaksBZ6AJR6J-A_VwwnQ6/view?usp=sharing",
"https://drive.google.com/file/d/1dSI4yc1w-ycy_It9PLKnQ-_5n3BzabU0/view?usp=sharing",
"https://drive.google.com/file/d/1eI304z7YzPCdvDmVq20pYv_lyTa-f0u6/view?usp=sharing",
"https://drive.google.com/file/d/1ekam5r9uRUGMjbV4MRnmyzpxyyuKYWc7/view?usp=sharing",
"https://drive.google.com/file/d/1elj8rQb3FEk-XvYUg5G2hCgnih_aH2VF/view?usp=sharing",
"https://drive.google.com/file/d/1eoN7x-rVTqc9HFRNLAftTzIuh5M0Figh/view?usp=sharing",
"https://drive.google.com/file/d/1eobbZdbtq4sJZKIIJR0zncJZGu-UYzTI/view?usp=sharing",
"https://drive.google.com/file/d/1erxz6gxrCbF6DG7q_w8XrKUBQ6Y4N0uO/view?usp=sharing",
"https://drive.google.com/file/d/1f9GfKbIR9-3_75Z3nLxwrCUyNDctlV_n/view?usp=sharing",
"https://drive.google.com/file/d/1fCAI5RrdvXr4FmFhBMISGRKD81pGMEVg/view?usp=sharing",
"https://drive.google.com/file/d/1fK7LHXd7KHWZiTChkvbqDQDUHfz5HGpl/view?usp=sharing",
"https://drive.google.com/file/d/1fOiDY7zYwakTzxLwV56RYHwlgfctpJdF/view?usp=sharing",
"https://drive.google.com/file/d/1fx_ZDU9s0qt8Q5pHsmflAXhvMa7799EL/view?usp=sharing",
"https://drive.google.com/file/d/1grXudfKVydm7aSUxdH9dImpv-M8buDNa/view?usp=sharing",
"https://drive.google.com/file/d/1gvIkZ5oVZaqinEPaAWjmR_ByvtI6y_Bi/view?usp=sharing",
"https://drive.google.com/file/d/1h7Bk_ZqCMx22Vpjj6-pB1E-Tql0-q7yh/view?usp=sharing",
"https://drive.google.com/file/d/1hF3hQ-q_dXUngcWs--LAygfs8GFfsr0h/view?usp=sharing",
"https://drive.google.com/file/d/1hPifvk53Ql2BcQ62J_3v-mf0x5c0fx5A/view?usp=sharing",
"https://drive.google.com/file/d/1i7ZCFxefr6InOlsrgFwMXyc6t9dQB2X8/view?usp=sharing",
"https://drive.google.com/file/d/1iBP25SY05Y3Nkx6ME_P0RwoxlQNJPsu1/view?usp=sharing",
"https://drive.google.com/file/d/1iEGVtWY1Are03Nf6s5VDn_uFLstmjCwb/view?usp=sharing",
"https://drive.google.com/file/d/1iLByBuz7Fsn-ic6qIlrXbe7OiVxouk9_/view?usp=sharing",
"https://drive.google.com/file/d/1iUW6jvZKJi2yeXlCWVsimGaZJYKwEwQF/view?usp=sharing",
"https://drive.google.com/file/d/1ijAMy7A2qrxI8MafoKUPWjedDTePwp8Q/view?usp=sharing",
"https://drive.google.com/file/d/1irk1mnqJKN1wxTlXpv-nEJ9ESJENO6YB/view?usp=sharing",
"https://drive.google.com/file/d/1j6Sssz2RiWwMixx-6CMR2d9uO77wHfNL/view?usp=sharing",
"https://drive.google.com/file/d/1jHklEjPPTZlUWdp4RdSggKppZoMr6gYL/view?usp=sharing",
"https://drive.google.com/file/d/1jMWGsM9RkmkaTf0VEqN4kgxQVRYUYrjl/view?usp=sharing",
"https://drive.google.com/file/d/1j_R4G_00tr8MV6GY9eWgy1gG6rIeavdV/view?usp=sharing",
"https://drive.google.com/file/d/1jb1Qf6kLNOo2M4UbcClovMMuSepVj9wd/view?usp=sharing",
"https://drive.google.com/file/d/1kCGF7d1XUV8m9NfTaqGqqhc5yBbEQw5o/view?usp=sharing",
"https://drive.google.com/file/d/1kHDJTeSJE9ACSTG-pBGSeUVmwoPZiCDJ/view?usp=sharing",
"https://drive.google.com/file/d/1kRmGPvsTyk-6HG47InesHrKSwRYFHeGu/view?usp=sharing",
"https://drive.google.com/file/d/1kcFwHVEtuGXg7SmpNvcQUMnvgKlru7IV/view?usp=sharing",
"https://drive.google.com/file/d/1kdyLQSWRo7QKQZ9VKunMSg-UDdsnwutG/view?usp=sharing",
"https://drive.google.com/file/d/1kmk4dSE2EXNHh76oQCQv8XkyS4Fvfwzz/view?usp=sharing",
"https://drive.google.com/file/d/1kwfgZuiogu16d3kU7sHDINPB_hqVB3kQ/view?usp=sharing",
"https://drive.google.com/file/d/1lGGKzoSh2K_zMlDrOIgfv9TvEHjN5Tsh/view?usp=sharing",
"https://drive.google.com/file/d/1lR6yt1qaz6tQF19P_UDAdX3BgsoHaeyS/view?usp=sharing",
"https://drive.google.com/file/d/1l_iFMgDVE6tKyWWNcjwO4Na0g1yTTPBE/view?usp=sharing",
"https://drive.google.com/file/d/1m0_srwUDPqJ_Gh71GEoi-T-fbcAlOB4v/view?usp=sharing",
"https://drive.google.com/file/d/1mO-BtRgnnoBNjRM9UnPcYfIq2pVKNZ_4/view?usp=sharing",
"https://drive.google.com/file/d/1m_V0e3cZkbvC1b4uyVdo5YMXI7EvCbXD/view?usp=sharing",
"https://drive.google.com/file/d/1mit7JTYZCWBh1Jrjxz4rhDocP1W3kZZy/view?usp=sharing",
"https://drive.google.com/file/d/1mjRH-yOjZW8gztQ8XNQukDW1KpjVDP5L/view?usp=sharing",
"https://drive.google.com/file/d/1nDyygpTO5X6IW8grb79n47-Rt3jRlKQF/view?usp=sharing",
"https://drive.google.com/file/d/1nETsI41JOewEg4Iok7lMtgm1t7NNFzKv/view?usp=sharing",
"https://drive.google.com/file/d/1nMfJgN9917qfsDdnj1pSF7M17N5iV2ca/view?usp=sharing",
"https://drive.google.com/file/d/1nMl-z3z1ZAEy_w665Ls_JWOwvyNcbRVX/view?usp=sharing",
"https://drive.google.com/file/d/1nRpzvUeMMjtk3jzEU0Gb35kxD-G9hFeP/view?usp=sharing",
"https://drive.google.com/file/d/1nVq9hzO43Un_EB1ZYluSvdrF_m79apiB/view?usp=sharing",
"https://drive.google.com/file/d/1nWnjsvn0FHqmauTvrKVNqH9DXRqOhUJD/view?usp=sharing",
"https://drive.google.com/file/d/1nioZjtnvNmS4xYsj6dEAG__sSWYDEL-z/view?usp=sharing",
"https://drive.google.com/file/d/1nyte9PBtEC_8Ly7_Y-pL_BAxevB03r44/view?usp=sharing",
"https://drive.google.com/file/d/1p0bkFPWFExHIS7cO8pXS_ZwhV5wqUmAk/view?usp=sharing",
"https://drive.google.com/file/d/1pT8TTSOF3bkza7xm9d0jYtohAy_t1aJR/view?usp=sharing",
"https://drive.google.com/file/d/1pbiTqLU2LcE8YFxL2wLS97R_hs3lI-cq/view?usp=sharing",
"https://drive.google.com/file/d/1pjG8izshe918FmfQO5d4ue3qVR5kr9Rc/view?usp=sharing",
"https://drive.google.com/file/d/1px6tPCgQ74iI-Xia2gR-TTYn-y6avnh4/view?usp=sharing",
"https://drive.google.com/file/d/1q35IlU2bDnFYwSXciTpqhIov1cZd5rV6/view?usp=sharing",
"https://drive.google.com/file/d/1qL3LcO2J2WhCq0IXdNntxaS37t3KCaRF/view?usp=sharing",
"https://drive.google.com/file/d/1qONGQ-ugQXZm0p0D1c0GgKzc0loh6X1D/view?usp=sharing",
"https://drive.google.com/file/d/1qOkjJrjB9Rw0Vt9ig7JKZRcvhDvr8At0/view?usp=sharing",
"https://drive.google.com/file/d/1qXbZ0pJQdHZmVwzeBjlbim4Y-RqvYKON/view?usp=sharing",
"https://drive.google.com/file/d/1qZk61PNpqipRs-mJgJrOXavzp_HsXuyN/view?usp=sharing",
"https://drive.google.com/file/d/1qbWwVAtVxLe_V75ABeCOFDhLhkm-kHGz/view?usp=sharing",
"https://drive.google.com/file/d/1qgGMSkKkW4f4oSJopkv80qrA6_6uwSek/view?usp=sharing",
"https://drive.google.com/file/d/1qkFD9iBgWZ6uteGKeUNaZgMO9AvSW5Ze/view?usp=sharing",
"https://drive.google.com/file/d/1r6-Rd6q2dcG3x9_qVlRngnP0c0DXdFYa/view?usp=sharing",
"https://drive.google.com/file/d/1rTO-_LA7oz9i49rHwGGJc8AAC-ygn_Fq/view?usp=sharing",
"https://drive.google.com/file/d/1rWQLd34hePMx9BCU1C9YvzPJkxyka-Xs/view?usp=sharing",
"https://drive.google.com/file/d/1rgnbYViRsfygpbnFFpAPwgp_A1rZnowV/view?usp=sharing",
"https://drive.google.com/file/d/1rilG4dIbZKB_1pAo248i43qfyN2NaOHT/view?usp=sharing",
"https://drive.google.com/file/d/1rq1E5IQKRT8zD8ONeFt_oE4d-UW7N0uf/view?usp=sharing",
"https://drive.google.com/file/d/1sNQefcNFZvLWqvyBllxbKICTozXoUmrq/view?usp=sharing",
"https://drive.google.com/file/d/1tNE2Bk99vwBZdqiQsQdChESPRIyGVV86/view?usp=sharing",
"https://drive.google.com/file/d/1tz93eaauQMalQpfrwJOAS2iI3X7h1sqp/view?usp=sharing",
"https://drive.google.com/file/d/1tzp-3XNNLXbZ6GoCNAiB1_re-R1YvgPv/view?usp=sharing",
"https://drive.google.com/file/d/1u1OanQbXWZIx5nN9q6rtW_ylIkMvBZOL/view?usp=sharing",
"https://drive.google.com/file/d/1udrmb4Io4jW7L8Stbf8L_3dnqY1wX5_R/view?usp=sharing",
"https://drive.google.com/file/d/1ueINQvhoS2orBl7sBYuNShPXXZHXhxBY/view?usp=sharing",
"https://drive.google.com/file/d/1unLgrZBVVEbk1YfBhK0APnfM8mXcvQ35/view?usp=sharing",
"https://drive.google.com/file/d/1v8rienYPjPa4sBOo-cLLVPV36rJ_fBIS/view?usp=sharing",
"https://drive.google.com/file/d/1vLd-mTKbnv2iavDKXHLXtK_G_lYiW295/view?usp=sharing",
"https://drive.google.com/file/d/1vkBnjgGq-dhCpRKbn40USQGR4K26iNEE/view?usp=sharing",
"https://drive.google.com/file/d/1wWZJCJ89va2Vq1pIuzJjrWZAKWQ4MAT7/view?usp=sharing",
"https://drive.google.com/file/d/1wWyWoNt-98LGx7XrIWqouOa1r1Wmuhgo/view?usp=sharing",
"https://drive.google.com/file/d/1wjh6ZKMdyq2paJTNtee6kOyC_nRO9LeG/view?usp=sharing",
"https://drive.google.com/file/d/1wminNyyfQtEOpdBllv2X_jzvsytA4hcQ/view?usp=sharing",
"https://drive.google.com/file/d/1woEi11P2X0MwqGS_J-sX-caqP9Ce5ypZ/view?usp=sharing",
"https://drive.google.com/file/d/1wxhR_RXH9djD8uYp-XaK_SG_eYNHy7Zv/view?usp=sharing",
"https://drive.google.com/file/d/1wzW_89FVHl3iQwQvMBwrzGs11VxGYM3x/view?usp=sharing",
"https://drive.google.com/file/d/1x1LdXuCQExrvH4OmpfCccnk3F5_q1pAq/view?usp=sharing",
"https://drive.google.com/file/d/1x_scefClDXK_2G3GVm8D5q0mZZPUrQk1/view?usp=sharing",
"https://drive.google.com/file/d/1xcYH3XRP3-8pb8YTkbNyTzR1dt_il0qJ/view?usp=sharing",
"https://drive.google.com/file/d/1xwL152J8Eix5cA0jNoXtHM0biAl9WTl4/view?usp=sharing",
"https://drive.google.com/file/d/1y4_IbckKzTYWEwJkufUcGXyhl5hwdoUn/view?usp=sharing",
"https://drive.google.com/file/d/1z0Q_nrHBc7271FmxbvpV9zMkRaMOvXCF/view?usp=sharing",
"https://drive.google.com/file/d/1zBLeJ7dnGC2Q1oSyUl_-RbxIQ2GzH17o/view?usp=sharing",
"https://drive.google.com/file/d/1zCdK4m3c1KU4OkGzi7vroAkE9SchEpvp/view?usp=sharing",
"https://drive.google.com/file/d/1zKOCdHhHQfg4-kFaKGpFy72NdGvjQz0V/view?usp=sharing",
"https://drive.google.com/file/d/1zL2gycL5G_0ymtjaHbKe4tB8VnrlCqDg/view?usp=sharing",
"https://drive.google.com/file/d/1zL9yhXwqgrm6q3Fkkz31IEc4U0r2sv0e/view?usp=sharing",
"https://drive.google.com/file/d/1ziv6d7nGA6r_nS9fQ2FsvWNgNls86fOw/view?usp=sharing"
];

$count_success = 0;
$count_failed  = 0;

echo "Starting download and processing of " . count($urls) . " products...\n";

// Remove first one since we already processed it successfully as a test!
array_shift($urls);

foreach ($urls as $index => $url) {
    preg_match('/d\/(.*?)\//', $url, $match);
    if (!isset($match[1])) {
        echo "[File " . ($index+2) . "] Failed: Could not extract Google Drive ID from URL\n";
        $count_failed++;
        continue;
    }
    
    $id = $match[1];
    $download_url = "https://drive.google.com/uc?export=download&id=" . $id;

    // Get headers to find original filename securely
    $headers = get_headers($download_url, 1);
    $filename = "unknown-" . mt_rand(1000, 9999) . ".jpg";
    if (isset($headers['Content-Disposition'])) {
        $cd = is_array($headers['Content-Disposition']) ? end($headers['Content-Disposition']) : $headers['Content-Disposition'];
        if (preg_match('/filename\*=UTF-8\'\'(.+)|filename="(.+?)"/i', $cd, $m)) {
            $filename = urldecode(!empty($m[1]) ? $m[1] : $m[2]);
        }
    } else {
        if(isset($headers['Location'])) {
            $loc = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
            $headers2 = get_headers($loc, 1);
            if (isset($headers2['Content-Disposition'])) {
                $cd = is_array($headers2['Content-Disposition']) ? end($headers2['Content-Disposition']) : $headers2['Content-Disposition'];
                if (preg_match('/filename="(.+?)"/i', $cd, $m)) {
                    $filename = $m[1];
                }
            }
        }
    }
    
    $info = pathinfo($filename);
    $sku = sanitize_title($info['filename']);
    $title = ucwords(str_replace(['-', '_'], ' ', $info['filename']));

    $tmp = download_url( $download_url );
    if ( is_wp_error( $tmp ) ) {
        echo "[- $sku -] Failed downloading: " . $tmp->get_error_message() . "\n";
        $count_failed++;
    } else {
        $file_array = array(
            'name'     => $filename,
            'tmp_name' => $tmp
        );
        $attachment_id = media_handle_sideload( $file_array, 0 );
        if( is_wp_error($attachment_id) ) {
            echo "[- $sku -] Failed attaching image: " . $attachment_id->get_error_message() . "\n";
            @unlink($tmp);
            $count_failed++;
        } else {
            // First check if a draft product with this SKU exists and we can just overwrite it? 
            // Wait, we drafted them. Let's just create NEW pristine products since the user wants a clean slate of 300 perfectly matched items.
            $post_id = wp_insert_post([
                'post_title'   => $title,
                'post_status'  => 'publish',
                'post_type'    => 'product',
            ]);
            update_post_meta($post_id, '_sku', $sku);
            set_post_thumbnail($post_id, $attachment_id);
            echo "[+ $sku +] Success! Created Product ID $post_id ($title)\n";
            $count_success++;
        }
    }
}

echo "\n==============================\n";
echo "PROCESS COMPLETE\n";
echo "Successfully created: $count_success products.\n";
echo "Failed: $count_failed URLs.\n";
