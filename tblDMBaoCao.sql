USE [SPA_SAIGONDEP]
GO
/****** Object:  Table [dbo].[tblDMBaoCao]    Script Date: 12-Feb-21 5:50:16 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblDMBaoCao](
	[MaBaoCao] [varchar](100) NOT NULL,
	[TenBaoCao] [nvarchar](250) NOT NULL,
	[TenBaoCaoNN] [nvarchar](250) NOT NULL,
	[BaoCaoSo] [varchar](20) NULL,
	[SuDung] [bit] NULL,
	[ThuTuTrinhBay] [int] NULL,
	[NhomBaoCao] [nvarchar](250) NULL,
 CONSTRAINT [PK_tblDMBaoCao] PRIMARY KEY CLUSTERED 
(
	[MaBaoCao] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoBanHang', N'Báo Cáo Bán Hang', N'Sales Report', N'1', 1, 1, N'1')
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoBieuDo', N'Báo Cáo Biểu Đồ', N'Chart Report', NULL, 1, 1, NULL)
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoHangHoa', N'Báo Cáo Hàng Hóa', N'Goods Report', NULL, 1, 1, NULL)
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoKhachHang', N'Báo Cáo Khách Hàng', N'Client Report', NULL, 1, 1, NULL)
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoNhanVien', N'Báo Cáo Nhân Viên', N'Staff Report', NULL, 1, 1, NULL)
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoNhapXuat', N'Báo Cáo Nhập Xuất', N'Warehousing Report', NULL, 1, 1, NULL)
INSERT [dbo].[tblDMBaoCao] ([MaBaoCao], [TenBaoCao], [TenBaoCaoNN], [BaoCaoSo], [SuDung], [ThuTuTrinhBay], [NhomBaoCao]) VALUES (N'BaoCaoSoLieu', N'Báo Cáo Số Liệu', N'Statistics Report', NULL, 1, 1, NULL)
GO
ALTER TABLE [dbo].[tblDMBaoCao] ADD  CONSTRAINT [DF__tblDMBaoC__SuDun__104AE8AC]  DEFAULT (1) FOR [SuDung]
GO
ALTER TABLE [dbo].[tblDMBaoCao] ADD  CONSTRAINT [DF_tblDMBaoCao_ThuTuTrinhBay]  DEFAULT (1) FOR [ThuTuTrinhBay]
GO
